<?php

namespace App\Domain\Build\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuildController extends Controller
{
    public function index(): \Inertia\Response
    {
//        $slide = new Message([
//            'title' => 'Reprog Moteur',
//            'text' => 'L\'assurance n\'est plus responsable',
//        ]);

//        dd($slide);

        return Inertia::render("Build::Index", [
            'name' => 'Gerard Darmont'
        ]);
    }
}
