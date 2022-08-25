<?php

namespace ComeenPlay\SdkPhp\Interfaces;

interface IScenario
{
    public function getName();
    public function getOptions();
    public function getOption($name, $default = null);
    public function run(array $data_tokens = []);
}
