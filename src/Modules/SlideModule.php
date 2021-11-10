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
//
//    public function setOption($name, $value): self
//    {
//        $options = $this->options;
//        if (Arr::exists($options, $name)) {
//            Arr::forget($options, $name);
//        }
//        Arr::set($options, $name, $value);
//        $this->options = $options;
//        return $this;
//    }
//
//    public function forgetOption($key)
//    {
//        $options = $this->options;
//        Arr::forget($options, $key);
//        $this->options = $options;
//    }
//
//    public function getTriggerableAttribute(){
//        return $this->slide_set->triggerable ?? false;
//    }
//
//    public function getTriggerSettingsAttribute(){
//        if(isset($this->slide_set->triggerable) && $this->slide_set->triggerable){
//            $trigger_settings = $this->slide_set->trigger_settings;
//            $trigger_settings['max_duration'] = (int) ($trigger_settings['max_duration'] ?? 5);
//            $trigger_settings['proximity_range'] = (int) ($trigger_settings['proximity_range'] ?? 1);
//            $trigger_settings['repeat_content'] = boolval($trigger_settings['repeat_content'] ?? false);
//            return $trigger_settings;
//        }
//        return [];
//    }
//
//    public function getFirstTriggerIdAttribute()
//    {
//        if(empty($this->trigger_ids)){
//            return null;
//        }
//
//        return $this->trigger_ids[array_key_first($this->trigger_ids)];
//    }

}
