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
        $full = collect([]);

        $slides = request()->all();

        collect(request()->all())->each(function ($slideData, $key) use ($full) {
            $module = Module::whereIdentifier(Arr::get($slideData, 'module'))->firstOrFail();

            if (!Arr::get($slideData, 'options')) {
                $full->add([
                    $key => [
                        'error' => 'Invalid or malformed data passed',
                        'data' => null,
                    ]
                ]);
            }

            $options = $slideData['options'];

            $handler = $module->getHandler($module);
            $slideHandler = new $handler($module);

            $data = $slideHandler->fetch(new SlideModule($options));

            $full->add([
                $key => [
                    'data' => $data,
                    'options' => $options
                ]
            ]);
        });

        return response()->json($full);
    }
}
