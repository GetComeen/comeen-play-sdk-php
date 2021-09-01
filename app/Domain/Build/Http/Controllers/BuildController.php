<?php

namespace App\Domain\Build\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuildController extends Controller
{
    public function index(): \Inertia\Response
    {

        return Inertia::render("Build::Index", [
            'name' => 'Gerard Darmont'
        ]);
    }
}
