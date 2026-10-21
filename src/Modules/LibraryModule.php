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
        return self::retryWithResign(
            ['api_key' => $display->getAPIKey()],
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            fn($signed) => self::createApiClient()->get("/display/list-folders?" . http_build_query($signed))->throw()->json()
        );
    }

    public static function uploadMedias($space_id, array $files)
    {
        $files = array_values($files);

        // The binary content of the files cannot be part of the signed payload,
        // so we bind each file to the signature through its SHA-256 hash. The
        // Manager verifies these hashes against the actually uploaded files.
        $fileHashes = array_map(fn($file) => hash('sha256', $file->get()), $files);

        // Multipart form fields are always transmitted as strings, so we sign
        // string values to make sure the Manager rebuilds an identical payload.
        $params = [
            'space_id' => (string) $space_id,
            'file_hashes' => $fileHashes,
        ];

        return self::retryWithResign(
            $params,
            fn($p) => app(RequestSignatureGenerator::class)->signRequestParameters($p),
            function ($signed) use ($files) {
                $request = self::createApiClient()->asMultipart();

                foreach ($files as $i => $file) {
                    $request = $request->attach("medias-$i", $file->get(), $file->getClientOriginalName());
                }

                return json_decode(
                    $request->post('/app-server/medias/upload', $signed)->throw()->body()
                );
            }
        );
    }
}
