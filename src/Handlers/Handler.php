<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\IModule;

abstract class Handler
{
    protected IModule $module;

    public function __construct(IModule $module)
    {
        return $this->module = $module;
    }

    final public function getIdentifier()
    {
        return $this->module->identifier;
    }

    final public function getName()
    {
        return $this->module->name;
    }

    final public function getFullIdentifier()
    {
        return $this->app()->identifier .  '.' . $this->getType() . '.' . $this->getIdentifier() . '::' . $this->getVersion();
    }

    final public function getDescription()
    {
        return $this->module->description;
    }

    final public function getType()
    {
        return $this->module->type;
    }

    final public function getVersion()
    {
        return $this->app()->version;
    }

    final public function getIcon()
    {
        return $this->module->icon;
    }

    final public function getColor()
    {
        return $this->module->color;
    }

    final public function app()
    {
        return $this->module->application;
    }

    public function getDefaultOptions()
    {
        return [];
    }

    public function processOptions($options)
    {
        return $options;
    }

    public function getValidations($options = null): array
    {
        return [
            'rules' => [],
            'messages' => []
        ];
    }

    public function toArray()
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
}
