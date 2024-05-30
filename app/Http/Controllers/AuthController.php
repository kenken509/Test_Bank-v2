<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return inertia('Authentication/Login');
    } 

    public function store(Request $request)
    {
        //dd($request->password);
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => [
        //         'required',
        //         'string',
        //         Password::min(8)
        //             ->mixedCase()
        //             ->numbers()
        //             ->symbols(),
        //     ],
        // ], [
        //     'password.required' => 'The password field is required.',
        //     'password' => 'The password must be at least 8 characters long and contain both uppercase and lowercase letters, at least one number, and at least one special character.'
        // ]);
        
        if(!Auth::attempt($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]), true)){ // remember me = true
            throw ValidationException::withMessages([
                'email' => 'Authentication Failed.'
            ]);
        };  
        
        $request->session()->regenerate();

        return redirect()->route('dashboard.show')->with('success', 'Successfully registered! Please check your email for verification!');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('success', 'Successfully Logged out.');
    }
}
