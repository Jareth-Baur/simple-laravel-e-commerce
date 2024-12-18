<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Ensure this view exists
    }

    public function login(Request $request)
    {
        // Validate the login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the admin in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // If successful, redirect to the admin dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        }

        // If unsuccessful, redirect back with an error
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('shop.index')->with('success', 'You have been logged out.');
    }
}
