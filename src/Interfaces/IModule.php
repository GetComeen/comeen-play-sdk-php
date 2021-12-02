<?php

namespace DynamicScreen\SdkPhp\Interfaces;

/**
 * @property string $name
 * @property string $type
 * @property string $logo
 * @property string $color
 * @property string $description
 * @property string $identifier
 * @property string $application_id
 * @property array $options
 * @property array $config
 * @property $application
 */
interface IModule
{
    public function application();
    public function getOption($key, $default = null);
    public function translationFilesPath();
    public function getHandlerClass();
    public function getHandler(...$config);
}
