<?php

namespace App\Http\Middleware;

use App\Services\CashAccess;
use Closure;
use Illuminate\Http\Request;

class CashUnlocked
{
    public function handle(Request $request, Closure $next)
    {
        if (!app(CashAccess::class)->allowed($request)) {
            $request->session()->forget('cash');
            return redirect()->route('cash.unlock');
        }

        return $next($request);
    }
}
