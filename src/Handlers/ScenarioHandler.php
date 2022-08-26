<?php

namespace ComeenPlay\SdkPhp\Handlers;

use ComeenPlay\SdkPhp\Interfaces\IScenario;

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
