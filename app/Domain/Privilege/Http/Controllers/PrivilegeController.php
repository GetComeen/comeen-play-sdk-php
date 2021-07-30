<?php

namespace App\Domain\Privilege\Http\Controllers;

use App\Domain\Privilege\Model\Privilege;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PrivilegeController extends Controller
{
    public function index(): \Inertia\Response
    {
        $privileges = Privilege::all();
        return Inertia::render("Privilege::Index", [
            'privileges' => $privileges
        ]);
    }
}
