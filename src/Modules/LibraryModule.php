<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use GuzzleHttp\Client;
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

    public static function uploadMedias($space_id, array $files)
    {
        // TODO find a way to sign multipart requests with uploaded files
        // TODO refacto to use the HTTP Client (see https://laravel.com/docs/8.x/http-client#multi-part-requests)

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
                $multipart[] = [
                    'name' => "medias-$i",
                    'filename' => $file->getClientOriginalName(),
                    'contents' => $file->get()
                ];
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
