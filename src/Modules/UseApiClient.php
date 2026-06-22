<?php

namespace ComeenPlay\SdkPhp\Modules;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use function config;

trait UseApiClient
{
    private static function createApiClient(): PendingRequest
    {
        $attempt = 0;
        return Http::baseUrl(config('services.api.url'))
            ->withHeaders([
                'Referer' => config('app.url'),
                'Accept' => 'application/json',
            ])
            ->retry(5, 0, function (\Exception $exception) use (&$attempt): bool {
                if (!$exception instanceof RequestException || $exception->response->status() !== 429) {
                    return false;
                }
                usleep((int) min(1000000 * (2 ** $attempt++), 30000000));
                return true;
            });
    }
}
