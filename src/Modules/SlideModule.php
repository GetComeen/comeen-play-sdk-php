<?php

namespace DynamicScreen\SdkPhp\Modules;

use Illuminate\Support\Arr;
use DynamicScreen\SdkPhp\Interfaces\ISlide;

class SlideModule implements ISlide
{
    private array $slide = [];

    public function __construct(array $options)
    {
        $this->slide = $options;
    }

    public function getName()
    {
        return $this->getOption('name');
    }

    public function getOptions(): array
    {
        return Arr::get($this->slide, 'options', []);
    }

    public function getOption($name, $default = null)
    {
        return Arr::get($this->getOptions(), $name, $default);
    }


    public function getMedia($key)
    {
        return Arr::get($this->slide, "medias.$key", []);
    }

    public function getMedias()
    {
        return Arr::get($this->slide, "medias", []);
    }

    public function getAccount($key)
    {
        return Arr::get($this->slide, "accounts.$key", []);
    }

    public function getAccounts()
    {
        return Arr::get($this->slide, "accounts", []);
    }
}
