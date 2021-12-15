<?php


namespace DynamicScreen\SdkPhp\Handlers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

abstract class BaseAuthProviderHandler extends Handler
{
    protected static string $provider = 'unknown';
    protected array $data_buffer = [];

    abstract public function testConnection($request);

    public function provideData($settings = [])
    {

    }

    final public function getData($key)
    {
        $method = Arr::get($this->data_buffer, $key);
        if ($method && is_callable($method)) {
            return $method();
        }

        return [];
    }

    final protected function addData(string $key, callable $data): void
    {
        $this->data_buffer[$key] = $data;
    }

    public function toArray()
    {
       return array_merge(
           parent::toArray(),
           ['is_safe_to_be_public' => $this->isSafeToBePublic()]
       );
    }

    public function isSafeToBePublic()
    {
        return false;
    }

    public final function getProviderIdentifier(): string
    {
        return static::$provider;
    }
}
