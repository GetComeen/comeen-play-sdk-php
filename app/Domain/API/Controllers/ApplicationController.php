<?php

namespace App\Domain\API\Controllers;

use Aiken\i18next\i18Next;
use App\Domain\Application\Model\Application;
use App\Domain\Authorization\Model\Authorization;
use App\Domain\Build\Model\Build;
use App\Domain\Module\Model\Module;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public function getBuild($appId): \Illuminate\Http\JsonResponse
    {
        $build = Build::where([
            'application_id' => $appId,
            'version' => request()->get('version'),
            'channel' => request()->get('channel')
        ])->with('application')->get();

        if ($build->isEmpty()) {
            return response()->json('No available build for this version');
        }

        $slidePath = $build->first()->application->getOption('path'). '/dist/'. $build->first()->application->name .'.js';
        $optionsPath = $build->first()->application->getOption('path'). '/dist/'. $build->first()->application->name .'Options.js';

        return response()->json([
            'slide' => File::get($slidePath),
            'options' => File::get($optionsPath)
        ]);
    }
}
