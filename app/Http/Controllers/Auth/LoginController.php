<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Handle empty or invalid roles
            if (empty($user->role) || !in_array($user->role, ['admin', 'lecturer', 'student'])) {
                // Default to student if role is invalid
                return redirect('/student');
            }
            
            // SIMPLE REDIRECTION
            if ($user->role === 'admin') {
                return redirect('/admin');
            } 
            if ($user->role === 'lecturer') {
                return redirect('/lecturer');
            }
            return redirect('/student');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}