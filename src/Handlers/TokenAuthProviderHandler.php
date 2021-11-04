<?php


namespace DynamicScreen\SdkPhp\Handlers;

abstract class TokenAuthProviderHandler extends BaseAuthProviderHandler
{

    abstract public function endpoint_uri();

    public function getDefaultOptions()
    {
        return [
            'key' => ''
        ];
    }

    public final function getOptionsValidator(array $options)
    {
        return $this->optionsValidator($this->makeValidator($options), $options);
    }

    public function optionsValidator(\Illuminate\Validation\Validator $validator, array $options)
    {
        $validator->addRules([
            'key' => 'required'
        ]);

        $validator->addCustomAttributes([
            'key' => $this->getTokenName()
        ]);

        return $validator;
    }

    public function getTokenName()
    {
        return 'Token';
    }

    protected final function makeValidator(array $values = [])
    {
        return app('validator')->make($values, []);
    }
}
