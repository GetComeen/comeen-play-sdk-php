<?php

namespace App\Domain\Bundle\Http\Controllers;

use App\Domain\Bundle\Model\Bundle;
use App\DTO\BundleDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BundleController extends Controller
{
    public function index(): \Inertia\Response
    {
        $bundles = Bundle::all();
        return Inertia::render("Bundle::Index", [
            'bundles' => BundleDTO::collection($bundles)
        ]);
    }

    public function show(Bundle $bundle): \Inertia\Response
    {
        $bundle->load('applications');
        return Inertia::render("Bundle::Show", [
            'bundle' => BundleDTO::make($bundle)
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        $data = $request->validate([
//            'name' => ['required', 'max:30'],
//            'description' => ['required', 'max:150'],
//            'logo' => null,
//        ]);

        $data = [
            'name' => 'Google Workspace',
            'description' => 'Google Workspace bundle including gsheet, gdoc, gslide, datastudio and many more...',
            'logo' => null,
        ];

        $bundle = Bundle::create($data);
        $bundle->save();
        $bundle->applications()->sync(collect([1, 2]));
        return redirect(route('bundles.index'));
    }
}
