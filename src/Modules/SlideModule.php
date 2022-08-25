<?php

namespace ComeenPlay\SdkPhp\Modules;

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
        return Arr::get($this->slide, 'name', '');
    }

    public function getDuration()
    {
        return Arr::get($this->slide, 'duration', 5);
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

    public function getTemplate()
    {
        return Arr::get($this->slide, "template", []);
    }
}
