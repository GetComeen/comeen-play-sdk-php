<?php


namespace App\Domain\Application\Importer;


use App\Domain\Application\Model\Application;

class ApplicationImporterInstance
{
    public static function get($type, Application $app = null)
    {
        switch($type) {
            case 'url':
                return new UrlImporter($app);
            case 'zip':
                return new ZipImporter($app);
            case 'path':
                return new PathImporter($app);
            default:
                return 'sorry dude';
                break;
        }
    }
}
