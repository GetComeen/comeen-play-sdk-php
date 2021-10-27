<?php
namespace DynamicScreen\SdkPhp\Interfaces;

interface ISlide {
    public function getName();
    public function getOptions();
    public function getOption($name, $default = null);
//    public function getMedia($media_id);
//    public function getMedias(array $media_ids);
//    public function getExternalAccount($type);
//    public function getRemoteFile($remote_file_id) : ?IRemoteFile;
//    public function getRemoteFiles(array $remote_file_ids);
}
