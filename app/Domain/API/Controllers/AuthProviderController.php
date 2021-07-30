<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Build\Model\Build;
use App\Domain\Bundle\Model\Bundle;
use App\Domain\Module\Model\Module;
use App\Domain\Resource\Model\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Socialite\Facades\Socialite;

class AuthProviderController extends Controller
{
    use HasApiTokens;

    public function initiate($provider): \Illuminate\Http\JsonResponse
    {
        $token = Str::random(50);
        return response()->json([
//            'redirect_url' => $url,
            'token' => $token,
        ]);
    }

    public function connect($provider)
    {
        $data = request()->validate([
            'token' => ['required', 'string', 'size:50'],
            'callback_url' => ['required', 'url']
        ]);

        $clientId = config("services.$provider.client_id");
        $clientSecret = config("services.$provider.client_id");
        $redirectUrl = $data['callback_url'];
        $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl);

        return Socialite::driver($provider)->setConfig($config)->stateless(true)->redirect();

        return response()->json("Cannot redirect to the $provider auth provider");
    }

    public function test($provider): \Illuminate\Http\JsonResponse
    {

        return response()->json(['success' => true]);
    }
}
