<?php

namespace ComeenPlay\SdkPhp\Handlers;

use ComeenPlay\SdkPhp\Interfaces\IModule;

abstract class OAuthProviderHandler extends BaseAuthProviderHandler
{
    protected $default_config = [];

    abstract public function signin($config);
    abstract public function callback($request, $redirectUrl = null);


    public function __construct(IModule $module, $config = null)
    {
        parent::__construct($module);
        $this->default_config = $config;
    }

    public function refreshToken($config = null)
    {
        return $config;
    }
}
