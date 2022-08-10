<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface IDisplay {
    public function getName();
    public function getLogoURL();
    public function getLanguage();
    public function getTimezone();
    public function getLocation();
    public function getOrientation();
    public function getUnitSystem();
    public function getClockFormat();
    public function getMetadata();
}
