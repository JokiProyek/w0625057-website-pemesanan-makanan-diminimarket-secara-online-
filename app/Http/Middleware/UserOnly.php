<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        if (Auth::user()->utype === 'USR') {
            return $next($request);
        }

        return redirect()->route('admin.index')->with('error', 'Admin tidak boleh mengakses halaman ini.');
    }
}
