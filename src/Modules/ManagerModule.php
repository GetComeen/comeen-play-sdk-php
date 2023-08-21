<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use function app;

class ManagerModule
{
    use UseApiClient;

    public static function refreshSlides($space_id, $slide_type, $display_metadata_key, $display_metadata_value): void
    {
        self::createApiClient()
            ->post(
                "/app-server/slides/refresh",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "space_id" => $space_id,
                    "type" => $slide_type,
                    "display_metadata_key" => $display_metadata_key,
                    "display_metadata_value" => $display_metadata_value,
                ])
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
}
