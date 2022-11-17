<?php

namespace ComeenPlay\SdkPhp\Modules;

use Illuminate\Support\Arr;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use GuzzleHttp\Client;

class LibraryModule
{
    public static function listFolders(IDisplay $display)
    {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        return json_decode($client->get("/display/list-folders?api_key=" . $display->getAPIKey())->getBody()->getContents());
    }
}
