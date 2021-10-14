<?php

namespace App\Domain\Application\Http\Controllers;

use App\Domain\Application\Importer\ApplicationImporterInstance;
use App\Domain\Application\Model\Application;
use App\DTO\ApplicationDTO;
use App\Http\Controllers\Controller;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Symplify\GitWrapper\GitWrapper;

class ApplicationController extends Controller
{
    public function index(): \Inertia\Response
    {
        $apps = Application::all();
        return Inertia::render("Application::Index", [
            'applications' => ApplicationDTO::collection($apps),
        ]);
    }

    public function show(Application $application): \Inertia\Response
    {
        $application->load('modules');
        return Inertia::render("Application::Show", [
            'application' => ApplicationDTO::make($application),
        ]);
    }

    public function sync(Application $application): \Illuminate\Http\RedirectResponse
    {
        Artisan::call("application:sync $application->id");

        return Redirect::route('applications.show', $application->id);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'type' => ['required', 'in:url,zip'],
            'zip' => ['exclude_if:type,url', 'required', 'file'],
            'url' => ['exclude_if:type,zip', 'required', 'url']
        ]);

        if ($data['type'] === 'zip' && !$data['zip']->isValid()) {
            return redirect()->back()->withErrors(['zip' => 'The provided file is not a valid zip.']);
        }

        $value = Arr::get($data, $data['type']);
        try {
            $importer = optional(ApplicationImporterInstance::get($data['type']));
            $app = $importer->import($value);
        } catch (\Exception $e) {
            $importer->cancelImport();
            return redirect()->back()->withErrors(['message' => "Application import has failed: ". $e->getMessage()]);
        }

        if (!$app) {
            return redirect()->back()->withErrors(['type' => 'Error during import process.']);
        }

        return Redirect::route('applications.show', $app->id);
    }

    public function update(): \Inertia\Response
    {
        $apps = Application::all();
        return Inertia::render("Application::Index", [
            'applications' => $apps
        ]);
    }

    public function destroy(Application $application)
    {
        if ($application->delete()) {
            Session::flash('notif.success', "Application \"$application->name\" has been successfully removed.");
        } else {
            Session::flash('notif.error', "Application \"$application->name\" cannot be removed");
        }

        return redirect()->route('applications.index');
    }
}
