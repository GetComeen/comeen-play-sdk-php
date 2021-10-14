<?php


namespace App\Domain\Application\Importer;

use App\Domain\Application\Model\Application;
use Symfony\Component\Yaml\Yaml;

class PathImporter extends ApplicationImporter
{
    public function __construct(Application $app = null)
    {
        parent::__construct($app);
        $this->type = 'path';
    }

    public function fetch($value)
    {
        $this->value = $value;
        $this->path = $value;
        $this->content = Yaml::parseFile($value.'/manifest.yml');
        return $value;
    }

    public function update()
    {
        // TODO: Implement sync() method.
    }
}
