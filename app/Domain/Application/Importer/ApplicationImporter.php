<?php


namespace App\Domain\Application\Importer;


use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use App\Domain\Module\Model\Module;
use App\Domain\Privilege\Model\Privilege;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

abstract class ApplicationImporter
{
    public $type;
    public $value;
    public $app;
    public $path;
    public $content;
    public $builds;
    public $modules;
    public $privileges;

    abstract function fetch($value);
    abstract function update();

    public function __construct(Application $app = null)
    {
        $this->app = $app;

        if ($app) {
            $this->type = $app->import_type;
        }
    }

    public function getAttribute($key, $default = null)
    {
        return Arr::get($this->content, $key, $default);
    }

    public function versionHasChanged(): bool
    {
        return $this->app->version !== $this->getAttribute('version');
    }

    public function sync(): Application
    {
        if (!$this->app->auto_sync) {
            echo "App version has changed, new app has been created instead";
            return $this->app;
        }

        $this->update();
        if ($this->versionHasChanged()) {
            $this->import($this->app->getOption('repository'));
//            $app_id = Artisan::call('import:application --type='. $this->app->import_type . ' ' .$this->app->getOption('repository'));
            echo "App version has changed, new app has been created instead";
            return $this->app;
        }
        $this->app = $this->createApp();
        $this->modules = $this->createModules();

        Artisan::call('generate:webpack-config '. $this->app->id);
        Artisan::call('build:application '. $this->app->id);

        $this->builds = $this->createBuilds();
        $this->privileges = $this->createPrivileges();

        echo 'Modules have been successfully built';

        return $this->app;

    }

    public function import($value): Application
    {
        $this->value = $value;
        $this->path = $this->fetch($value);
        $this->app = $this->createApp($value);
        $this->modules = $this->createModules();


        $this->install_node_modules();
        $this->build_webpack_artifacts();

        $this->builds = $this->createBuilds();
        $this->privileges = $this->createPrivileges();

        return $this->app;
    }

    private function install_node_modules(): int
    {
        $process = Process::fromShellCommandline('cd ' .$this->path. ' && yarn install');
        return $process->run(null, ['PATH' => ':/usr/local/bin']);
    }

    private function install_composer_packages(): int
    {
        $process = Process::fromShellCommandline('cd ' .$this->path. ' && composer install');
        return $process->run(null, ['PATH' => ':/usr/local/bin']);
    }

    private function build_webpack_artifacts()
    {
        Artisan::call('generate:webpack-config '. $this->app->id);
        Artisan::call('build:application '. $this->app->id);
    }

    public function createApp($value = null): Application
    {
        $app = !$value ? $this->app : new Application([]);

        $options = [
            'path' => $this->path ?? $this->app->getOption('path'),
            'author' => [
                'name' => $this->getAttribute('author.name'),
                'email' => $this->getAttribute('author.email'),
            ],
        ];

        if ($this->type === 'url') {
            $options['repository'] = $value ?? $this->app->getOption('repository');
        }

        $app->options = $options;

        $app->name = $this->getAttribute('name');
        $app->logo = $this->getAttribute('logo');
        $app->description = $this->getAttribute('description');
        $app->type = $this->getAttribute('id');
        $app->version = $this->getAttribute('version');
        $app->color = $this->getAttribute('color');
        $app->channel = $this->getAttribute('channel');
        $app->api_level = $this->getAttribute('api-level');
        $app->import_type = $this->type;
        $app->config = json_encode($this->content);

        if (Str::startsWith($this->getAttribute('logo'), './')) {
            $filename = pathinfo($this->getAttribute('logo'), PATHINFO_BASENAME);
            $file = Storage::disk('apps')->get($app->type .'/'. $app->version .'/'. $this->getAttribute('logo'));
            Storage::disk('public')->put($filename, $file);
        }

        $app->save();
        return $app;
    }

    public function createModules(): Array
    {
        $modules = $this->getAttribute('modules');
        collect($modules)->each(function ($module) {
            $existingModule = $this->app->modules->firstWhere('identifier', Arr::get($module, 'identifier'));
            $mod = $existingModule ?? new Module($module);
            $mod->config = $module;

//            $mod->options = [
//                'vue' => Arr::get($module, 'vue'),
//                'php' => Arr::get($module, 'php'),
//                'node' => Arr::get($module, 'node'),
//            ];
            $mod->options = Arr::get($module, 'options', []);
            $mod->application_id = $this->app->id;
            $mod->save();
        });
        return $modules;
    }

    // REMOVE BUILD TABLE ??
    // LINK PRIVILEGES TO APP AND USE APP INFO INSTEAD OF BUILDS

    public function createBuilds(): Build
    {
        $build = $this->app->builds->first();

        if ($build) {
            $build->touch();
        } else {
            $build = Build::create([
                'path' => $this->app->getOption('path'),
                'version' => $this->app->version,
                'channel' => $this->app->channel,
                'api_level' => $this->app->api_level,
                'application_id' => $this->app->id,
            ]);

            $build->save();
        }

        return $build;
    }

    public function createPrivileges()
    {
        $privileges_list = collect($this->getAttribute('privileges'));
        $privileges_list->each(function ($privileges, $type) {
            $priv_list = collect($privileges)->map(function ($privilege) use ($type) {
                $existingPrivilege = optional($this->builds->privileges)->firstWhere('identifier', Arr::get($privilege, 'identifier'));
                $priv = $existingPrivilege ?? new Privilege();
                $priv->identifier = Arr::get($privilege, 'identifier');
                $priv->type = $type;
                $priv->why = Arr::get($privilege, 'why');
                if (in_array($type, ['needs_account', 'needs_media'])) {
                    $options = ['type' => Arr::get($privilege, 'type')];
                } else {
                    $options = [];
                }
                $priv->options = $options;
                if ($priv->isClean()) {
                    $priv->touch();
                } else {
                    $priv->save();
                }

                return $priv->id;
            });

            $this->builds->privileges()->sync($priv_list);
        });

        return $privileges_list;
    }

    public function cancelImport() {
        if ($this->path) {
            exec("rm -rf $this->path");
            if ($this->app) {
                $this->app->delete();
            }
        }
    }
}
