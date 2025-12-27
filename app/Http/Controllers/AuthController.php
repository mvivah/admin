<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {

        if (Auth::check() && $request->has('redirect_to')) {
        $user = Auth::user();
        $token = $user->createToken('sso-token')->plainTextToken;
        $redirectTo = $request->input('redirect_to');
        // Security: check allowed clients from env
        $allowed = array_filter(array_map('trim', explode(',', env('SSO_ALLOWED_CLIENTS', ''))));
        $ok = false;
        foreach ($allowed as $a) {
            if (str_starts_with($redirectTo, $a)) { $ok = true; break; }
        }
        if ($ok) {
            $sep = str_contains($redirectTo, '?') ? '&' : '?';
            $target = $redirectTo . $sep . 'token=' . urlencode($token);
            return redirect()->away($target);
        }
    }
        $redirectTo = $request->query('redirect_to');
        return view('auth.login', compact('redirectTo'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'redirect_to' => 'nullable|url',
        ]);

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $user = Auth::user();

        // create personal access token (abilities can be adjusted)
        $token = $user->createToken('sso-token')->plainTextToken;
        $redirectTo = $request->input('redirect_to');

        if ($redirectTo) {
            // Security: check allowed clients from env
            $allowed = array_filter(array_map('trim', explode(',', env('SSO_ALLOWED_CLIENTS', ''))));
            $ok = false;
            foreach ($allowed as $a) {
                if (str_starts_with($redirectTo, $a)) { $ok = true; break; }
            }

            if ($ok) {
                // Append token as query param (use HTTPS in prod)
                $sep = str_contains($redirectTo, '?') ? '&' : '?';
                $target = $redirectTo . $sep . 'token=' . urlencode($token);
                return redirect()->away($target);
            }
        }

        // fallback: redirect to portal and show token (for testing)
        return redirect()->route('portal')->with('token', $token);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // revoke all tokens (or choose to revoke current only)
        $user->tokens()->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
