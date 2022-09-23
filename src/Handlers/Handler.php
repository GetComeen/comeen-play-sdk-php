<?php

namespace ComeenPlay\SdkPhp\Handlers;

use ComeenPlay\SdkPhp\Interfaces\IModule;
use ComeenPlay\SdkPhp\Modules\DisplayModule;
use ComeenPlay\SdkPhp\Modules\SlideModule;

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

    protected function getTranslation($key)
    {
        return $this->module->application->i18n->getTranslation($key);
    }

    public function provideRemoteMethods()
    {

    }

    public function addRemoteMethod(string $key, callable $method) {
        $this->method_buffer[$key] = $method;
    }

    final public function callRemoteMethod($key, $parameters, $details)
    {
        $method = Arr::get($this->method_buffer, $key);
        if ($method && is_callable($method)) {
            $display = Arr::get($details, 'display');
            $slide = Arr::get($details, 'slide');
            $account = Arr::get($details, 'account');
            return $method($parameters, [
                'display' => $display ? new DisplayModule($display) : null,
                'slide' => $slide ? new SlideModule($display) : null,
                'account' => $account,
            ]);
        }

        return [];
    }
}
