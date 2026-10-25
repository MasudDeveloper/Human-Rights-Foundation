<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'দয়া করে অ্যাডমিন হিসেবে লগইন করুন।');
        }

        if (session('admin_role') !== 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'এই কার্যক্রমে প্রবেশের অনুমতি শুধুমাত্র সুপার অ্যাডমিনের রয়েছে।');
        }

        return $next($request);
    }
}
