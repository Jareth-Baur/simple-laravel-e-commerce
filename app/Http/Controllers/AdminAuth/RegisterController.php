<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; // Ensure you import the Admin model if necessary

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.register'); // Ensure this view exists
    }

    public function register(Request $request)
    {
        // Validate the registration form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the admin
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
        ]);

        // Optionally log in the admin
        // Auth::guard('admin')->login($admin);

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please log in.');
    }
}
