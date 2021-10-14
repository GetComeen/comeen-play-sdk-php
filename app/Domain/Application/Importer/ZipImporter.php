<?php


namespace App\Domain\Application\Importer;


use App\Domain\Application\Model\Application;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

class ZipImporter extends ApplicationImporter
{
    public function __construct(Application $app = null)
    {
        parent::__construct($app);
        $this->type = 'url';
    }

    public function fetch($value)
    {
        $this->value = $value;

        $zip = new \ZipArchive;
        if ($zip->open($this->value)) {
            $manifest = $zip->getFromName('manifest.yml');
//            if (!$manifest) {
//                throw new \Exception('Missing Manifest.yml configuration file at root.');
//            }
            $this->content = Yaml::parse($manifest);
//            if (!$this->content) {
//                throw new \Exception('manifest.yml not well formatted.');
//            }
            $version = $this->getAttribute('version');
            $identifier = $this->getAttribute('id');
            $dir_path = "/$identifier/$version";
            Storage::disk('apps')->makeDirectory($dir_path);
            Storage::disk('apps')->makeDirectory("$dir_path/dist");
            $app_path = Storage::disk('apps')->getAdapter()->getPathPrefix().$dir_path;
            $zip->extractTo($app_path);
            $zip->close();
        } else {
            echo "Failed to open zip...\n";
            return null;
        }

        return $app_path;
    }

    public function update()
    {
        // TODO: Implement sync() method.
    }
}
