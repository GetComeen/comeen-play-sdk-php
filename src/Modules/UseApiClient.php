<?php

namespace ComeenPlay\SdkPhp\Modules;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use function config;

trait UseApiClient
{
    private static function createApiClient(): PendingRequest
    {
        return Http::baseUrl(config('services.api.url'))
            ->withHeaders([
                'Referer' => config('app.url'),
            ]);
    }
}
