<?php


namespace App\Domain\Application\Importer;


use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use App\Domain\Module\Model\Module;
use App\Domain\Privilege\Model\Privilege;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
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

    abstract function fetchApp($value);

    public function getAttribute($key, $default = null)
    {
        return Arr::get($this->content, $key, $default);
    }

    public function import($value)
    {
        $this->value = $value;
        $this->path = $this->fetchApp($value);
        $this->app = $this->createApp($value);
        $this->modules = $this->createModules();
        $this->build = $this->createBuilds();
        $this->privileges = $this->createPrivileges();

        $this->install_node_modules();
        $this->build_webpack_artifacts();

        return $this->app;
    }

    private function install_node_modules(): int
    {
        $process = Process::fromShellCommandline('cd ' .$this->path. ' && npm install');
        return $process->run(null, ['PATH' => ':/usr/local/bin']);
    }

    private function build_webpack_artifacts()
    {
        Artisan::call('generate:webpack-config '. $this->app->id);
        Artisan::call('build:application '. $this->app->id);
    }

    public function sync($value)
    {

//        $this->value = $value;
//        $this->path = $this->fetchApp($value);
//        $this->app = $this->updateApp();
//        $this->modules = $this->updateModules();
//        $this->build = $this->updateBuilds();
//        $this->privileges = $this->updatePrivileges();


        return $this->app;
    }

    public function createApp($value = null): Application
    {
        $app = new Application([]);

        $options = [
            'path' => $this->path,
            'author' => [
                'name' => $this->getAttribute('author.name'),
                'email' => $this->getAttribute('author.email'),
            ],
        ];

        if ($this->type === 'url') {
            $options['repository'] = $value;
        }

        $app->options = $options;

        $app->name = $this->getAttribute('name');
        $app->logo = $this->getAttribute('logo');
        $app->description = $this->getAttribute('description');
        $app->type = $this->getAttribute('id');
        $app->version = $this->getAttribute('version');
        $app->channel = $this->getAttribute('channel');
        $app->api_level = $this->getAttribute('api-level');
        $app->import_type = $this->type;
        $app->save();

        if (Str::startWith($app->logo, './')) {
            Storage::put();
        }

        return $app;
    }

    public function createModules(): Array
    {
        $modules = $this->getAttribute('modules');
        collect($modules)->each(function ($module) {
            $mod = new Module($module);
            $mod->options = [
                'vue' => Arr::get($module, 'vue'),
                'php' => Arr::get($module, 'php'),
                'node' => Arr::get($module, 'node'),
            ];
            $mod->application_id = $this->app->id;
            $mod->save();
        });

        return $modules;
    }

    public function createBuilds(): Build
    {
        $build = Build::create([
            'path' => $this->path,
            'version' => $this->getAttribute('version'),
            'channel' => $this->getAttribute('channel'),
            'api_level' => $this->getAttribute('api-level'),
            'application_id' => $this->app->id,
        ]);
        $build->save();

        return $build;
    }

    public function createPrivileges()
    {
        $privileges_list = collect($this->getAttribute('privileges'));
        $privileges_list->each(function ($privileges, $type) {
            $priv_list = collect($privileges)->map(function ($privilege) use ($type) {
                $priv = new Privilege();
                $priv->identifier = Arr::get($privilege, 'identifier');
                $priv->type = $type;
                $priv->why = Arr::get($privilege, 'why');
                if ($type === 'needs_account') {
                    $options = ['type' => Arr::get($privilege, 'type')];
                } else {
                    $options = null;
                }
                $priv->options = $options;
                $priv->save();

                return $priv->id;
            });

            $this->build->privileges()->sync($priv_list);
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
