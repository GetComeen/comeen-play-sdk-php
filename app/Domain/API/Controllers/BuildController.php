<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Module\Model\Module;
use App\Domain\Resource\Model\Resource;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class BuildController extends Controller
{
    use HasApiTokens;

    public function create(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
//        $module->load('builds.priviliges');
        return response()->json($module->builds);
    }

    public function update(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
//        $data = $app->validateRequest($request);
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
