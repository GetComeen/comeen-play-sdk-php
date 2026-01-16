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

    public static function getAccountOptions($account_id)
    {
        return self::createApiClient()
            ->get(
                "/app-server/account/$account_id/options",
                app(RequestSignatureGenerator::class)->signRequestParameters([])
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

    public static function getQrCodeInstanceUrl($content, $slide_id, $display_id): string
    {
        $queryStringParams = http_build_query(
            app(RequestSignatureGenerator::class)->signRequestParameters([
                "content" => $content,
                "slide_id" => "$slide_id",
                "display_id" => "$display_id",
            ])
        );

        return self::createApiClient()
            ->get("/app-server/get-qr-code-instance-url?$queryStringParams")
            ->throw();
    }

    public static function sendEmail($options): void
    {
        self::createApiClient()
            ->post(
                "/app-server/send-email",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "options" => $options,
                ])
            )
            ->throw();
    }

    public static function updateRemoteFile($remote_file_id, $options): void
    {
        self::createApiClient()
            ->patch(
                "/app-server/remote-file/$remote_file_id",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "model_data" => $options,
                ])
            )
            ->throw();
    }

    public static function updateRemoteFileOptions($remote_file_options_id, $options): void
    {
        self::createApiClient()
            ->post(
                "/app-server/remote-file/$remote_file_options_id/options",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "model_data" => $options
                ])
            )
            ->throw();
    }

    public static function sendDetectedChanges(array $changes): void
    {
        self::createApiClient()
            ->post(
                "/app-server/remote-files/change-detected",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    "changes" => $changes
                ])
            )
            ->throw();
    }
}
