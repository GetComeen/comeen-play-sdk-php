<?php

namespace ComeenPlay\SdkPhp\Modules;

use GuzzleHttp\Client;

class ManagerModule
{
    public static function refreshSlides($space_id, $slides_query)
    {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->post("/app-server/slides/refresh", [
            'json' => [
                "space_id" => $space_id,
                "query" => $slides_query,
            ]
        ]);
    }

    public static function updateAccountOptions($account_id, $options) {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->put("/app-server/account/$account_id/options", [
            'json' => [
                "options" => $options,
            ]
        ]);
    }

    public static function updateSlidesOptions($space_id, $slides_query, $options) {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->put("/app-server/$space_id/slides", [
            'json' => [
                "query" => $slides_query,
                "options" => $options,
            ]
        ]);
    }
}
