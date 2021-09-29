<?php

namespace App\Domain\Settings\Http\Controllers;

use App\Domain\User\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function show(): \Inertia\Response
    {
        $settings = DB::table('settings')->get(['key', 'value'])->pluck('value', 'key');
        return Inertia::render("Settings::Show", [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'repository_name' => ['required', 'max:40'],
            'author' => ['required', 'max:30'],
            'email' => ['required', 'max:50', 'email'],
            'company' => ['required', 'max:30'],
            'active' => ['required', 'boolean'],
        ]);

        $formatData = [
            ['key' => 'repository_name', 'value' => $data['repository_name']],
            ['key' => 'author', 'value' => $data['author']],
            ['key' => 'email', 'value' => $data['email']],
            ['key' => 'active', 'value' => $data['active']],
            ['key' => 'company', 'value' => $data['company']],
        ];

        try {
            DB::table('settings')->upsert($formatData, ['key'], ['value']);
        } catch (\Exception $e) {
            Session::flash('notif.error', ["title" => "Cannot update settings.", "content" => "An error occured, settings are not saved."]);
        }

        Session::flash('notif.success', ["title" => "Successfully updated", "content" => "Repository\'s settings has been successfully updated !"]);

        return redirect()->route('settings.show');
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
