<?php

namespace App\Domain\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Vendor\MyApp\Message;

class HomeController extends Controller
{
    public function index(): \Inertia\Response
    {
//        $slide = new Message([
//            'title' => 'Reprog Moteur',
//            'text' => 'L\'assurance n\'est plus responsable',
//        ]);

//        dd(phpinfo());

        return Inertia::render("Home::Index", [
            'name' => 'Gerard Darmont'
        ]);
    }
}
