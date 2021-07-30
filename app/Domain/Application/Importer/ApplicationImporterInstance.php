<?php


namespace App\Domain\Application\Importer;


class ApplicationImporterInstance
{
    public static function get($type)
    {
        switch($type) {
            case 'url':
                return new UrlImporter();
            case 'zip':
                return new ZipImporter();
            case 'path':
                return new PathImporter();
            default:
                return 'sorry dude';
                break;
        }
    }
}
