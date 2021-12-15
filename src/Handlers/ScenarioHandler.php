<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\IScenario;

abstract class ScenarioHandler extends Handler
{
    abstract public function getActionsType();

    public function getContext(IScenario $scenario)
    {
        return $this->getDescription();
    }

    public function scheduledRun(IScenario $scenario)
    {

    }
}
