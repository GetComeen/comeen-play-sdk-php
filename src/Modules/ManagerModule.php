<?php

namespace ComeenPlay\SdkPhp\Modules;

use GuzzleHttp\Client;

class ManagerModule
{
    public static function refreshSlides($space_id, $slide_type, $display_metadata_key, $display_metadata_value)
    {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->post("/app-server/slides/refresh", [
            'json' => [
                "space_id" => $space_id,
                "type" => $slide_type,
                "display_metadata_key" => $display_metadata_key,
                "display_metadata_value" => $display_metadata_value,
            ]
        ]);
    }
}
