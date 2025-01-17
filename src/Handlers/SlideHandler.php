<?php

namespace ComeenPlay\SdkPhp\Handlers;

use ComeenPlay\SdkPhp\Interfaces\ISlide;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use App\Domain\Module\Model\Module;
use Illuminate\Support\Arr;

abstract class SlideHandler extends Handler
{
    protected array $slide_buffer = [];
    protected array $method_buffer = [];

    abstract public function fetch(ISlide $slide, IDisplay $display): void;

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

        $modules = Module::all()->where('type', 'auth-provider');
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

    public function needs_dashboard()
    {
        return $this->module->getOption('privileges.needs_dashboard', false);
    }

    public function needed_templates()
    {
        return $this->module->getOption('privileges.needs_template', false);
    }

}
