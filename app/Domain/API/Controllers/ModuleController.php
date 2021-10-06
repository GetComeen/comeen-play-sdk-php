<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Module\Model\Module;
use App\Domain\Resource\Model\Resource;
use App\DTO\ModuleDTO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class ModuleController extends Controller
{
    use HasApiTokens;

    public function index(Application $app): \Illuminate\Http\JsonResponse
    {
        $modules = $app->load('modules')->paginate(request()->get('per_page', 10));
        return response()->json(ModuleDTO::paginated($modules));

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
}
