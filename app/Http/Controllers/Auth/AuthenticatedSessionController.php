<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'telephone' => 'required',
            'password' => 'required',
        ]);

        // Retrieve the credentials from the request
        $credentials = $request->only('telephone', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Retrieve the authenticated user
            $user = Auth::user();

                if ($request->has('redirect')) {
                return redirect($request->input('redirect'));
                }

            // Redirect based on the user's role
            if ($user->user_type === 'admin') {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->user_type === 'end_user') {
                return redirect()->intended('end_user/dashboard');
            } else {
                return redirect()->back()->with('error', 'You are not authorized to access any page.');
            }
        }

    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
