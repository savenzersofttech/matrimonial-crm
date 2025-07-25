<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
     public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect based on user role
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'super-admin' => redirect()->intended(route('admin.dashboard', absolute: false)),
                'admin' => redirect()->intended(route('admin.dashboard', absolute: false)),
                'sales' => redirect()->intended(route('sales.dashboard', absolute: false)),
                'services' => redirect()->intended(route('services.dashboard', absolute: false)),
                default => redirect()->intended(route('dashboard', absolute: false)),
            };
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
    
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $credentials = $request->only('email', 'password');

    //     // Attempt login with role-based guard
    //     foreach (['super-admin','admin', 'sales', 'services', 'web'] as $guard) {
    //         if (Auth::guard($guard)->attempt($credentials)) {
    //             $request->session()->regenerate();

    //             return match ($guard) {
    //                 'super-admin' => redirect()->intended(route('admin.dashboard')),
    //                 'admin' => redirect()->intended(route('admin.dashboard')),
    //                 'sales' => redirect()->intended(route('sales.dashboard')),
    //                 'services' => redirect()->intended(route('services.dashboard')),
    //                 default => redirect()->intended(route('dashboard')),
    //             };
    //         }
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
