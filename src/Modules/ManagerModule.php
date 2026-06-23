<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use function app;

class ManagerModule
{
    use UseApiClient;

    public static function refreshSlides($space_id, $slides_query): void
    {
        self::retryWithResign(
            ["space_id" => $space_id, "query" => $slides_query],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->post("/app-server/slides/refresh", $signed)->throw()
        );
    }

    public static function getAccountOptions($account_id)
    {
        return self::retryWithResign(
            [],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->get("/app-server/account/$account_id/options", $signed)->throw()
        );
    }

    public static function updateAccountOptions($account_id, $options): void
    {
        self::retryWithResign(
            ["options" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->put("/app-server/account/$account_id/options", $signed)->throw()
        );
    }

    public static function mergeAccountOptions($account_id, $options): void
    {
        self::retryWithResign(
            ["options" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->patch("/app-server/account/$account_id/options", $signed)->throw()
        );
    }

    public static function updateSlidesOptions($space_id, $slides_query, $options)
    {
        self::retryWithResign(
            ["query" => $slides_query, "options" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->put("/app-server/$space_id/slides", $signed)->throw()
        );
    }

    public static function getQrCodeInstanceUrl($content, $slide_id, $display_id): string
    {
        return self::retryWithResign(
            ["content" => $content, "slide_id" => "$slide_id", "display_id" => "$display_id"],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->get("/app-server/get-qr-code-instance-url?" . http_build_query($signed))->throw()
        );
    }

    public static function sendEmail($options): void
    {
        self::retryWithResign(
            ["options" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->post("/app-server/send-email", $signed)->throw()
        );
    }

    public static function updateRemoteFile($remote_file_id, $options): void
    {
        self::retryWithResign(
            ["model_data" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->patch("/app-server/remote-file/$remote_file_id", $signed)->throw()
        );
    }

    public static function updateRemoteFileOptions($remote_file_options_id, $options): void
    {
        self::retryWithResign(
            ["model_data" => $options],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->post("/app-server/remote-file/$remote_file_options_id/options", $signed)->throw()
        );
    }

    public static function sendDetectedChanges(array $changes): void
    {
        self::retryWithResign(
            ["changes" => $changes],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->post("/app-server/remote-files/change-detected", $signed)->throw()
        );
    }
}
