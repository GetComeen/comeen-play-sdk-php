<?php


namespace App\Domain\Application\Importer;


use App\Domain\Application\Model\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use Symplify\GitWrapper\GitWrapper;

class UrlImporter extends ApplicationImporter
{
    public function __construct(Application $app = null)
    {
        parent::__construct($app);
        $this->type = 'url';
    }

    public function fetch($value)
    {
        $disk = Storage::disk('apps');
        $disk->makeDirectory('/tmp');
        $this->path = $disk->getAdapter()->getPathPrefix(). 'tmp';

        $gitWrapper = new GitWrapper('git');
        $gitWrapper->cloneRepository($value, $this->path);

        $this->content = Yaml::parseFile($this->path.'/manifest.yml');
        $version = $this->getAttribute('version');
        $identifier = str_to_psr4($this->getAttribute('id'));
        $dir_path = "/$identifier/$version";
        $disk->makeDirectory($dir_path);
        $disk->makeDirectory("$dir_path/dist");
        $app_path = $disk->getAdapter()->getPathPrefix() . $dir_path;
        exec("cp -a $this->path/. $app_path");
        exec("rm -rf $this->path");

        return $app_path;
    }

    public function update()
    {
        $gitWrapper = new GitWrapper('git');
        $git = $gitWrapper->workingCopy($this->app->getOption('path'));

        $git->pull();

        $this->path = $this->app->getOption('path');
        $this->content = Yaml::parseFile($this->path.'/manifest.yml');
    }
}
