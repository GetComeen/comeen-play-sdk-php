<?php

namespace App\Domain\Resource\Http\Controllers;

use App\Domain\Resource\Model\Resource;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ResourceController extends Controller
{
    public function index(): \Inertia\Response
    {
        $resources = Resource::all();
        return Inertia::render("Resource::Index", [
            'resources' => $resources
        ]);
    }
}
