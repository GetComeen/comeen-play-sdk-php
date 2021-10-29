<?php

namespace App\Domain\API\Controllers;

use App\Domain\Module\Model\Module;
use App\Http\Controllers\Controller;
use DynamicScreen\SdkPhp\Modules\SlideModule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class ModuleResolverController extends Controller
{
    public function full(Request $request): JsonResponse
    {
        $full = [];

        $json = request()->getContent();
        if (!$json)
            return ['error' => 'invalid/missing json format'];

        $slides = json_decode($json, true);

        collect($slides)->each(function ($slideData, $key) use (&$full) {
            $module = Module::whereIdentifier(Arr::get($slideData, 'module'))->firstOrFail();

            if (!Arr::get($slideData, 'options')) {
                $full->add([
                    $key => [
                        'error' => 'Invalid or malformed data passed',
                        'data' => null,
                    ]
                ]);
            }

            $handler = $module->getHandler($module);
            $slideHandler = new $handler($module);

            $slideHandler->fetch(new SlideModule($slideData));


            $full[$key] = ['data' => $slideHandler->flushSlides()];
        });



        return response()->json($full);

    }
}
