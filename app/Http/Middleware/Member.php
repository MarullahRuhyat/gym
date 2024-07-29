<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Member
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('member.send-otp');
        }

        if (Auth::user()->role === 'member') {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');

        // if (Auth::check() && Auth::user()->role === 'member') {
        //     dd('member');
        //     return $next($request);
        // } else if (Auth::check() == false) {
        //     dd('not member');
        //     return redirect()->route('member.send-otp');
        // }
        // dd('not member');
        // abort(403, 'Unauthorized action.');
    }

}