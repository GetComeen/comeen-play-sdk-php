<?php

namespace App\Services\Auth;

use Illuminate\Auth\TokenGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class AuthorizationTokenGuard extends TokenGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $token = $this->getTokenForRequest();

        $user = $this->provider->retrieveByCredentials([
            $this->storageKey => $this->hash ? hash('sha256', $token) : $token,
            "channel" => request()->get('channel', 'stable'),
        ]);

        return $this->user = $user;
    }
}
