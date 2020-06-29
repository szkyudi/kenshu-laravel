<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;
use App\User;

class CheckOwner
{
    public function handle($request, Closure $next)
    {
        if ($request->user != Auth::user()) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
