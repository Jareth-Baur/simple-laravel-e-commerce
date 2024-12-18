<?php

namespace App\Http\Controllers; // Ensure this matches your namespace

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller // Ensure your class extends the correct base controller
{
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the admin in using the provided credentials
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
