<?php

namespace App\Http\Middleware;

use App\Domain\Application\Model\Application;
use App\Domain\Authorization\Model\Authorization;
use Closure;
use Illuminate\Http\Request;

class AuthenticateWithAppToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        return $next($request);
    }
}
