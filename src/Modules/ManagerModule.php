<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use function app;

class ManagerModule
{
    use UseApiClient;

    public static function refreshSlides($space_id, $slides_query): void
    {
        self::createApiClient()
            ->post(
                "/app-server/slides/refresh",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "space_id" => $space_id,
                    "query" => $slides_query,
                ])
            )
            ->throw();
    }

    public static function getAccountOptions($account_id): void
    {
        self::createApiClient()
            ->get(
                "/app-server/account/$account_id/options"
            )
            ->throw();
    }

    public static function updateAccountOptions($account_id, $options): void
    {
        self::createApiClient()
            ->put(
                "/app-server/account/$account_id/options",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "options" => $options,
                ])
            )
            ->throw();
    }

    public static function mergeAccountOptions($account_id, $options): void
    {
        self::createApiClient()
            ->patch(
                "/app-server/account/$account_id/options",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "options" => $options,
                ])
            )
            ->throw();
    }

    public static function updateSlidesOptions($space_id, $slides_query, $options)
    {
        self::createApiClient()
            ->put(
                "/app-server/$space_id/slides",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "query" => $slides_query,
                    "options" => $options,
                ])
            )
            ->throw();
    }
}
