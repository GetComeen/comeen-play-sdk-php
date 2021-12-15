<?php


namespace DynamicScreen\SdkPhp\Handlers;

abstract class TokenAuthProviderHandler extends BaseAuthProviderHandler
{

    abstract public function endpoint_uri();

    public function getDefaultOptions(): array
    {
        return [
            'key' => ''
        ];
    }

    public function getTokenName(): string
    {
        return 'Token';
    }
}
