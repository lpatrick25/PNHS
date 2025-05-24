<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if (
                ($user->role === "admin" && $request->is("admin/*")) ||
                ($user->role === "student" && $request->is("student/*")) ||
                ($user->role === "teacher" && $request->is("teacher/*")) ||
                ($user->role === "principal" && $request->is("principal/*"))
            ) {
                return $next($request);
            }

            switch ($user->role) {
                case "admin":
                    return redirect()->route('viewDashboardAdmin');
                case "student":
                    return redirect()->route('viewDashboardStudent');
                case "teacher":
                    return redirect()->route('viewDashboardTeacher');
                case "principal":
                    return redirect()->route('viewDashboardPrincipal');
                default:
                return redirect()->route('getLoginPage');
            }
        }

        return redirect()->route('getLoginPage');
    }
}
