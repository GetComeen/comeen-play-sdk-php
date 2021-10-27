<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface IScenario
{
    public function getName();
    public function getOptions();
    public function getExtensionSettings();
    public function getOption($name, $default = null);
    public function run(array $data_tokens = []);
}
