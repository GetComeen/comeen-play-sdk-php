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
}
