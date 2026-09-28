<?php

namespace App\Services;

use Illuminate\Http\Request;

class CashAccess
{
    public function fingerprint(): string
    {
        return hash_hmac('sha256', (string) config('cash.password'), (string) config('app.key'));
    }

    public function allowed(Request $request): bool
    {
        return (string) config('cash.password') !== ''
            && $request->session()->get('cash.user_id') === $request->user()->getAuthIdentifier()
            && (int) $request->session()->get('cash.expires_at', 0) > time()
            && hash_equals($this->fingerprint(), (string) $request->session()->get('cash.fingerprint', ''));
    }

    public function unlock(Request $request): void
    {
        $request->session()->regenerate();
        $request->session()->put('cash', [
            'user_id' => $request->user()->getAuthIdentifier(),
            'expires_at' => time() + (int) config('cash.unlock_minutes') * 60,
            'fingerprint' => $this->fingerprint(),
        ]);
    }
}
