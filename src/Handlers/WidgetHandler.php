<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\IWidget;

abstract class WidgetHandler extends Handler
{
    private array $widget_buffer = [];

    abstract public function fetch(IWidget $widget): void;

    final protected function addWidget($data): self
    {
        $this->widget_buffer[] = $data;
        return $this;
    }

    final public function flushWidgets(): array
    {
        $widgets = $this->widget_buffer;
        $this->widget_buffer = [];
        return $widgets;
    }
}
