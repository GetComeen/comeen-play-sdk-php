<?php

namespace App\Domain\Authorization\Http\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Authorization\Model\Authorization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthorizationController extends Controller
{
    public function index(): \Inertia\Response
    {
        $authorizations = Authorization::with('applications')->get();
        $applications = Application::all();
//        dd($applications->map->name);
        return Inertia::render("Authorization::Index", [
            'authorizations' => $authorizations,
            'applications' => $applications
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'max:40', 'min:2'],
            'channel' => ['required', 'in:stable,rc,beta,alpha'],
            'applications' => ['required', 'exists:applications,id'],
        ]);

        $data['api_token'] = Str::random(40);
        $authorization = Authorization::create($data);
        if (request()->get('applications')) {
            $authorization->applications()->sync($data['applications']);
        }
        Session::flash('notif.title', "Authorization \"$authorization->name\" has been successfully created.");


        return redirect()->route('authorizations.index');
    }

    public function update(Authorization $authorization)
    {
//        dd(request()->all());
        $data = request()->validate([
            'name' => ['required', 'max:40', 'min:2'],
            'channel' => ['required', 'in:stable,rc,beta,alpha'],
            'applications' => ['array'],
            'applications.*' => ['exists:applications,id'],
            'active' => ['required', 'boolean']
        ]);

        if (! empty($data['applications']) && is_null($authorization->api_token)) {
            $data['api_token'] = Str::random(40);
        }

        if (empty($data['applications']) && isset($authorization->api_token)) {
            $data['api_token'] = null;
        }

        $authorization->applications()->sync($data['applications']);
        $authorization->update($data);

        Session::flash('notif.title', "Authorization \"$authorization->name\" has been successfully updated.");


        return redirect()->route('authorizations.index');
    }

    public function destroy(Authorization $authorization)
    {
        if ($authorization->delete()) {
            Session::flash('notif.success.title', "Authorization \"$authorization->name\" has been successfully removed.");
        } else {
            Session::flash('notif.error.title', "Authorization \"$authorization->name\" cannot be removed");
        }

        return redirect()->route('authorizations.index');

    }
}
