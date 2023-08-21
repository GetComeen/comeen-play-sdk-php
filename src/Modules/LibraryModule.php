<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use function app;
use function http_build_query;

class LibraryModule
{
    use UseApiClient;

    public static function listFolders(IDisplay $display): array
    {
        $queryStringParams = http_build_query(
            app(RequestSignatureGenerator::class)->signRequestParameters([
                'api_key' => $display->getAPIKey(),
            ])
        );

        return self::createApiClient()
            ->get("/display/list-folders?$queryStringParams")
            ->throw()
            ->json();
    }

    public static function uploadMedias(array $files) {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        try {
            $multipart = [
                [
                    "name" => "space_id",
                    "contents" => "1"
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
