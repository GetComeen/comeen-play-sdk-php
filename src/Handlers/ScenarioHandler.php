<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\IScenario;

abstract class ScenarioHandler
{
    protected $hidden = false;

    abstract public function getName();
    abstract public function getActionsType();

    public function getIdentifier()
    {
        return str_slug($this->getName());
    }

    public final function getFullIdentifier()
    {
        return 'todo' . '.' . $this->getIdentifier();
    }

    public function getDescription()
    {
        return '';
    }

    public function getContext(IScenario $scenario)
    {
        return $this->getDescription();
    }

    public function getIcon()
    {
        return 'square';
    }

    public function getColor()
    {
        return '#239d00';
    }

    public final function getExtension()
    {
        return $this->extension;
    }

    public function getDefaultOptions()
    {
        return [];
    }

    public function getOptionsView($options)
    {
        return null;
    }

    public function processOptions($options, $creating)
    {
        return $options;
    }

    protected final function makeValidator(array $values = [])
    {
        return app('validator')->make($values, []);
    }

    public function optionsValidator(\Illuminate\Validation\Validator $validator, array $options)
    {
        return $validator;
    }

    public final function getOptionsValidator(array $options)
    {
        return $this->optionsValidator($this->makeValidator($options), $options);
    }

    public function scheduledRun(IScenario $scenario)
    {

    }

    public function hasTriggedState()
    {
        return false;
    }

}
