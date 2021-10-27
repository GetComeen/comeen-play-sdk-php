<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface IWidget
{
    public function getName();
    public function getOptions();
    public function getDisplay();
    public function getExtensionSettings();
    public function getExternalAccount($type);
}
