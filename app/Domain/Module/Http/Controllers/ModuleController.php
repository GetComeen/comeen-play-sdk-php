<?php

namespace App\Domain\Module\Http\Controllers;

use App\Domain\Module\Model\Module;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function show(Module $module): \Inertia\Response
    {
        $module->load('application');
        return Inertia::render("Module::Show", [
            'module' => $module
        ]);
    }
}
