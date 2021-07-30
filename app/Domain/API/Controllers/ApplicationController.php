<?php

namespace App\Domain\API\Controllers;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Authorization\Model\Authorization;
use App\Domain\Build\Model\Build;
use App\Domain\Module\Model\Module;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class ApplicationController extends Controller
{
    use HasApiTokens;

    public function index(): \Illuminate\Http\JsonResponse
    {
        $applications = Application::with('modules', 'builds.privileges')->get();
        return response()->json($applications);
    }

    public function show(Application $app): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', $app);

        $data = request()->validate([
            'version' => ['string'],
            'lang' => ['string']
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

    public function getBuildPath($appId): \Illuminate\Http\JsonResponse
    {
        $build = Build::where(['application_id' => $appId, 'version' => request()->get('version')])->get();

        if ($build->isEmpty()) {
            return response()->json('No available build for this version');
        }
        return response()->json($build);
    }
}
