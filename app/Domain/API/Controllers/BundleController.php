<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use App\Domain\Bundle\Model\Bundle;
use App\Domain\Module\Model\Module;
use App\Domain\Resource\Model\Resource;
use App\DTO\BundleDTO;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class BundleController extends Controller
{
    use HasApiTokens;

    public function index(): \Illuminate\Http\JsonResponse
    {
        $bundles = Bundle::with('applications')->paginate(request()->get('per_page', 10));

        return response()->json(BundleDTO::paginated($bundles));
    }

    public function show(Bundle $bundle): \Illuminate\Http\JsonResponse
    {
        $bundle->load('applications.modules');

        return response()->json(BundleDTO::make($bundle));
    }
}
