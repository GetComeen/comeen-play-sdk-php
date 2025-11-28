<?php

namespace ComeenPlay\SdkPhp\Handlers;

abstract class RemoteFileHandler extends Handler
{

    protected array $method_buffer = [];

    public function getRemoteMethods(): array
    {
        return array_keys($this->method_buffer);
    }

    abstract function fetch();

}