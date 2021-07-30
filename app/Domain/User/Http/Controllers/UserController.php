<?php

namespace App\Domain\User\Http\Controllers;

use App\Domain\User\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(): \Inertia\Response
    {
        $users = User::all();
        return Inertia::render("User::Index", [
            'users' => $users
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
      if ($request->get('generate_password') === true) {
        $request->merge(['password' => Str::random(12)]);
      }

      $validated = $request->validate([
        'user_name' => ['required', 'max:30'],
        'full_name' => ['required', 'max:50'],
        'email' => ['required', 'max:50', 'email'],
        'password' => ['required', 'min:4', 'max:20'],
        'generate_password' => ['required', 'boolean'],
      ]);

      if ($validated) {
        $user = User::create($validated);
        $user->password = Hash::make($validated['password']);
        $user->save();
        Session::flash('notif.title', 'Successfully created');
        Session::flash('notif.message', "$user->full_name ($user->user_name) has been successfully created !");
      }

      return Redirect::route("users.index");
    }

    public function update(): \Inertia\Response
    {
        $users = User::all();
        return Inertia::render("User::Index", [
          'users' => $users
        ]);
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
//        $validated = $request->validate([
//          'user_id'
//        ])



      if ($user->exists) {
        $user->delete();
        Session::flash('notif.title', 'Successfully deleted');
        Session::flash('notif.message', "$user->full_name ($user->user_name) has been successfully deleted !");
      }

      return Redirect::route("users.index");
    }
}
