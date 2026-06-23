<?php

namespace ComeenPlay\SdkPhp\Modules;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function config;

trait UseApiClient
{
    private static function createApiClient(): PendingRequest
    {
        return Http::baseUrl(config('services.api.url'))
            ->withHeaders([
                'Referer' => config('app.url'),
                'Accept' => 'application/json',
            ]);
    }

    /**
     * Execute an HTTP request with re-signing on each retry attempt.
     *
     * $requestFactory receives a fresh signed body and returns a Response:
     *   fn(array $signedParams): Response
     *
     * The $signer callable re-signs params fresh on each attempt:
     *   fn(array $params): array
     */
    private static function retryWithResign(array $params, callable $signer, callable $requestFactory): Response
    {
        $attempt = 0;
        $maxAttempts = 8;

        while (true) {
            $signedParams = $signer($params);
            try {
                return $requestFactory($signedParams);
            } catch (RequestException $e) {
                if ($e->response->status() !== 429 || $attempt >= $maxAttempts - 1) {
                    throw $e;
                }
                $delay = (int) min(4000000 * (2 ** $attempt), 60000000);
                usleep($delay);
                $attempt++;
            }
        }
    }
}
