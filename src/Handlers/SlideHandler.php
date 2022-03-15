<?php

namespace DynamicScreen\SdkPhp\Handlers;

use DynamicScreen\SdkPhp\Interfaces\ISlide;
use Illuminate\Support\Arr;

abstract class SlideHandler extends Handler
{
    protected array $slide_buffer = [];

    abstract public function fetch(ISlide $slide): void;

    public function getDefaultOptions()
    {
        return [];
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

    public function getAuthProvider(array $providerCredentialsList)
    {
        $authProviderIdentifier = $this->needed_accounts();

        if (is_array($authProviderIdentifier)) {
            $authProviderIdentifier = Arr::first($authProviderIdentifier);
        }

        $modules = $this->app()->modules->where('type', 'auth-provider');
        $mod = Arr::first($modules, fn($key, $value) => Arr::get($key, 'identifier') === $authProviderIdentifier);

        $config = Arr::first($providerCredentialsList, fn($credentials, $provider) => $provider === $mod->identifier);

        return $mod->getHandler($config);
    }

    public function needed_accounts()
    {
        return $this->module->getOption('privileges.needs_account', false);
    }

    public function needed_medias()
    {
        return $this->module->getOption('privileges.needs_media', false);
    }
}