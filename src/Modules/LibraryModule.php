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

    public static function uploadMedias($space_id, array $files) {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        try {
            $multipart = [
                [
                    "name" => "space_id",
                    "contents" => $space_id
                ]
            ];
            $i = 0;
            foreach ($files as $file) {
                // dd($file->get());
                array_push($multipart, [
                    'name' => "medias-$i",
                    'filename' => $file->getClientOriginalName(),
                    'contents' => $file->get()
                ]);
                $i++;
            }

            return json_decode($client->post("/app-server/medias/upload", [
                "multipart" => $multipart
            ])->getBody()->getContents());
        } catch (\Exception $e) {
            return [];
        }
    }
}
