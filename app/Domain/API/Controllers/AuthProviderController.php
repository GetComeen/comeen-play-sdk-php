<?php

namespace App\Domain\API\Controllers;

use App\Domain\Application\Model\Application;
use App\Domain\Module\Model\Module;
use App\Http\Controllers\Controller;
use Apps\DynamicScreen\Today\AuthProvider\UnsplashAuthProviderHandler;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class AuthProviderController extends Controller
{
    use HasApiTokens;

    public function initiate(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
        $token = Str::random(50);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function connect(Application $app, Module $module)
    {
        if ($module->type !== 'auth-provider') {
            return response()->json(['success' => false, 'data' => 'The following module is not an auth provider']);
        }

        $data = request()->validate([
            'redirect_url' => ['string', 'url'],
        ]);

//        if (!$provider) {
//            return response()->json(['success' => false, 'data' => 'The provided provider does not exist for the following module']);
//        }
        $callbackUrl = route('api.oauth.callback', [$app, $module, 'redirect_url' => $data['redirect_url']]);
        $authProviderHandler = $module->getHandler();

        return redirect($authProviderHandler->signin($callbackUrl));
    }

    public function test(Application $app, Module $module): \Illuminate\Http\JsonResponse
    {
        $data = request()->validate([
            'access_token' => ['required', 'string']
        ]);

        $handler = $module->getHandler($data);
        $status = $handler->testConnection();

        if (!$status) {
            response()->json(['success' => false, 'data' => null]);
        }

        return response()->json(['success' => true, 'data' => $status]);
    }

    public function callback(Application $app, Module $module)
    {
        $data = request()->validate([
            'redirect_url' => ['required']
        ]);

        $provider = $module->getOption('provider');

        if (!$provider) return response()->json(['success' => false]);

        $callbackUrl = route('api.oauth.callback', [$app, $module, 'redirect_url' => $data['redirect_url']]);

        $handler = $module->getHandler();

        return $handler->callback(request(), $callbackUrl);
    }

    public function userInfo($provider): \Illuminate\Http\JsonResponse
    {

        return response()->json(['success' => true, 'wip' => true]);
    }
}
