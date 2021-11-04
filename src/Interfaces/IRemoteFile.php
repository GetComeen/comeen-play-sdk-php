<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface IRemoteFile
{
    public function isReady() : bool;
    public function getUrl() : string;
    public function getMetadata() : array;
    public function metadata($key, $default = null);
}
