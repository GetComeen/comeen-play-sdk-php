<?php
namespace ComeenPlay\SdkPhp\Interfaces;

interface IDisplay {
    public function getId();
    public function getAPIKey();
    public function getName();
    public function getLogoURL();
    public function getLanguage();
    public function getTimezone();
    public function getLocation();
    public function getOrientation();
    public function getUnitSystem();
    public function getClockFormat();
    public function getMetadata($key);
    public function setMetadata($key, $value);
    public function refreshData();
}
