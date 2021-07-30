<?php


namespace App\Domain\Application\Importer;


use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use Symplify\GitWrapper\GitWrapper;

class UrlImporter extends ApplicationImporter
{
    public function __construct()
    {
        $this->type = 'url';
    }

    public function fetchApp($value)
    {
        $disk = Storage::disk('apps');
        $disk->makeDirectory('/tmp');
        $this->path = $disk->getAdapter()->getPathPrefix(). 'tmp';

        $gitWrapper = new GitWrapper('/usr/local/bin/git');
        $gitWrapper->cloneRepository($value, $this->path);

        $this->content = Yaml::parseFile($this->path.'/manifest.yml');
        $version = $this->getAttribute('version');
        $identifier = $this->getAttribute('id');
        $dir_path = "/$identifier/$version";
        $disk->makeDirectory($dir_path);
        $disk->makeDirectory("$dir_path/dist");
        $app_path = $disk->getAdapter()->getPathPrefix() . $dir_path;

        exec("cp -a $this->path/. $app_path");
        exec("rm -rf $this->path");

        return $app_path;
    }
}
