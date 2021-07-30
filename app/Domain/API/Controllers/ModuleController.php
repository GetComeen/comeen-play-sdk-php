<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Module\Model\Module;
use App\Domain\Resource\Model\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class ModuleController extends Controller
{
    use HasApiTokens;

    public function create(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', $module);

//        $module->load('builds.priviliges');
        return response()->json($module->builds);
    }

    public function show(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', $app);

        $data = request()->validate([
            'version' => ['string'],
            'language' => ['string']
        ]);

        $version = Arr::get($data, 'version');

        if ($version) {
            $app->load(['builds' => function ($q) use ($version) {
                $q->where('version', $version)->with('privileges');
            }]);
        } else {
            $app->load(['modules', 'builds.privileges']);
        }

        return response()->json($app);
    }

    public function update(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $module);

        $data = request()->all();

        $resource = Resource::create($data);

        $resource->module_id = $module->id;

        if ($data) {
            $module->update($data);
            $module->save();
        }

        // need to build
//        $resource->build_id = $build->id;

        return response()->json([$app, $module]);
    }
}
