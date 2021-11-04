<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface IAccount
{
    public function getName();
    public function getOptions();
    public function getOption($name, $default = null);
    public function getDriver();
}
