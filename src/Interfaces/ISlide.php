<?php
namespace ComeenPlay\SdkPhp\Interfaces;

interface ISlide {
    public function getName();
    public function getOptions();
    public function getDuration();
    public function getOption($name, $default = null);
    public function getMedia($key);
    public function getMedias();
    public function getAccount($key);
    public function getAccounts();
    public function getTemplate();
}
