<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->utype === "ADM") {
                if ($request->is('admin') || $request->is('admin/*')) {
                    return $next($request);
                }

                return redirect()->route('admin.index')->with('error', 'Admin tidak bisa mengakses halaman ini.');
            }

            Session::flush();
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }
}
