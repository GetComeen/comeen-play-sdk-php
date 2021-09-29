<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class ApplicationController extends Controller
{
    use HasApiTokens;

    public function index(): \Illuminate\Http\JsonResponse
    {
        $applications = Application::with('modules')->paginate(1);
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
//            $app->load(['builds' => function ($q) use ($version) {
//                $q->where('version', $version)->with('privileges');
//            }]);
        } else {
            $app->load(['modules']);
//            $app->load(['modules', 'builds.privileges']);
        }

        return response()->json($app);
    }

    public function getBuild($appId, $identifier): \Illuminate\Http\JsonResponse
    {

        $build = Build::where([
            'application_id' => $appId,
            'version' => request()->get('version'),
        ])->with('application')->get();

        if ($build->isEmpty()) {
            return response()->json('No available build for this version');
        }

        $scriptPath = $build->first()->application->getOption('path'). "/dist/$identifier";

        return response()->json(['component' => File::get($scriptPath)]);
    }

    public function getBuilds($appId): \Illuminate\Http\JsonResponse
    {
        $channel = request()->user()->channel;
        $version = request()->get('version');

        $app = Application::where('id', $appId)->whereHas('builds', function ($query) use ($version) {
            $query->where('version', $version);
        })->with('modules')->get()->first();

        if (!$app) {
            return response()->json('No available build for this version');
        }

        $output = $app->modules->map(function ($module) use ($appId, $version) {
            $slide_path = $module->getOption('vue.component');
            $options_path = $module->getOption('vue.options');

            $slide_filename = trim(substr($slide_path, strrpos($slide_path, '/') + 1));
            $options_filename = trim(substr($options_path, strrpos($options_path, '/') + 1));
            $slide_filename = str_replace(['.ts', '.vue'], '.js', $slide_filename);
            $options_filename = str_replace(['.ts', '.vue'], '.js', $options_filename);

            $slideUrl = route('applications.build', [$appId, $slide_filename]). "?version=$version";
            $optionsUrl = route('applications.build', [$appId, $options_filename]). "?version=$version";

            return [
                $module->identifier => [
                    'slide' => $slideUrl,
                    'options' => $optionsUrl,
                ],
            ];
        });

        return response()->json($output);
    }
}
