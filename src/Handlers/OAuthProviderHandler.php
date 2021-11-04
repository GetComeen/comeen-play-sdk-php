<?php

namespace DynamicScreen\SdkPhp\Handlers;

abstract class OAuthProviderHandler extends BaseAuthProviderHandler
{
    abstract public function signin($config);

    abstract public function callback($request, $redirectUrl = null);

    public function getCustomCreateStep2($account, $redirectUrl)
    {
        return redirect($redirectUrl);
    }

    public function refreshToken($account)
    {
        return false;
    }
}
