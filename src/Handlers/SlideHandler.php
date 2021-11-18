<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\IModule;
use DynamicScreen\SdkPhp\Interfaces\ISlide;

abstract class SlideHandler
{
    protected array $slide_buffer = [];
    protected IModule $module;

    abstract public function fetch(ISlide $slide): void;

    public function __construct(IModule $module)
    {
        $this->module = $module;
    }

    public function getIdentifier()
    {
        return $this->module->identifier;
    }

    public function getName()
    {
        return $this->module->name;
    }

    public final function getFullIdentifier()
    {
        return $this->app()->identifier .  '.' . $this->getType() . '.' . $this->getIdentifier() . '::' . $this->getVersion();
    }

    public function getDescription()
    {
        return $this->module->description;
    }

    public function getType()
    {
        return $this->module->type;
    }

    public function getVersion()
    {
        return $this->app()->version;
    }

    public function getIcon()
    {
        return $this->module->icon;
    }

    public function app()
    {
        return $this->module->application;
    }

    public function getImageIcon()
    {
        return null;
    }

    public function getColor()
    {
        return $this->module->color;
    }

    public function isCompatibleWithDisplayMode()
    {
        return true;
    }

    public function isCompatibleWithInteractiveMode()
    {
        return true;
    }

    public function getDefaultOptions()
    {
        return [];
    }

    public function processOptions($options)
    {
        return $options;
    }

    final protected function addSlide($slide)
    {
        $this->slide_buffer[] = $slide;
        return $this;
    }

    final public function flushSlides()
    {
        $slides = $this->slide_buffer;
        $this->slide_buffer = [];
        return $slides;
    }

    final public function toArray()
    {
        return [
            'full_identifier' => $this->getFullIdentifier(),
            'identifier' => $this->getIdentifier(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'icon' => $this->getIcon(),
            'type' => $this->getType(),
            'version' => $this->getVersion(),
        ];
    }

    public function getFullScreen()
    {
        return false;
    }

    protected function processList($list)
    {
        return collect($list)->values()->toArray();
    }

    public function getValidations()
    {
        return [
            'rules' => [],
            'messages' => []
        ];
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function isVisible()
    {
        return !$this->isHidden();
    }

    public function hasCorrectSettings($settings)
    {
        return true;
    }

    public function hasPadding()
    {
        return true;
    }

    public function displayOffline()
    {
        return false;
    }

    public function neededExternalAccounts()
    {
        return false;
    }
}
