<?php


namespace App\Domain\Application\Importer;

use Symfony\Component\Yaml\Yaml;

class PathImporter extends ApplicationImporter
{
    public function __construct()
    {
        $this->type = 'path';
    }

    public function fetchApp($value)
    {
        $this->value = $value;
        $this->path = $value;
        $this->content = Yaml::parseFile($value.'/manifest.yml');
        return $value;
    }
}
