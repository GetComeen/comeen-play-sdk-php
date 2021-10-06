<?php

namespace App\Domain\Module\Http\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Module\Model\Module;
use App\DTO\ApplicationDTO;
use App\DTO\ModuleDTO;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function show(Module $module): \Inertia\Response
    {
        $module->load('application')->makeVisible('application');
        return Inertia::render("Module::Show", [
            'module' => ModuleDTO::make($module)
        ]);
    }
}
