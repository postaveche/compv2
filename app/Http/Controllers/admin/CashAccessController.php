<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\CashAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CashAccessController extends Controller
{
    public function show(Request $request, CashAccess $access)
    {
        if ($access->allowed($request)) {
            return redirect()->route('cash.index');
        }
        return view('admin.cash.unlock');
    }

    public function unlock(Request $request, CashAccess $access)
    {
        $request->session()->forget('cash');
        $key = 'cash-unlock:'.$request->user()->getAuthIdentifier().':'.$request->ip();
        $password = $request->input('password');
        $configured = (string) config('cash.password');
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response('');
        }
        if ($configured === '' || !is_string($password) || !hash_equals($configured, $password)) {
            RateLimiter::hit($key, 60);
            return response('');
        }
        RateLimiter::clear($key);
        $access->unlock($request);
        return redirect()->route('cash.index');
    }

    public function lock(Request $request)
    {
        $request->session()->forget('cash');
        return redirect()->route('cash.unlock');
    }
}
