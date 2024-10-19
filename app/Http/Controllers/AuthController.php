<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password; // Add this line for the Password facade
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(){
        return View("Auth.register");
    }

    public function login()
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return redirect('/dashboard'); // Redirect to dashboard if authenticated
        }

        return view('Auth.login'); // Otherwise, show login page
    }


    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/landing');
            }        }

        // Debugging: Log the error or the credentials
        \Log::info('Login attempt failed', ['credentials' => $credentials]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }



    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/landing');
    }


    public function forgotPassword(){
        return View("Auth.forgotPassword");
    }

    public function ProfileUser(){
        return View("Profile.profileUser");
    }


 // Send reset password link to email
 public function sendResetLinkEmail(Request $request)
 {
     $request->validate(['email' => 'required|email']);

     // Send the password reset link
     $status = Password::sendResetLink($request->only('email'));

     return $status === Password::RESET_LINK_SENT
         ? back()->with(['status' => __($status)])
         : back()->withErrors(['email' => __($status)]);
 }

 // Show reset password form with token
 public function showResetPasswordForm($token)
 {
     return view('Auth.resetPassword', ['token' => $token]);
 }

 // Handle reset password logic
 public function resetPassword(Request $request)
 {
     $request->validate([
         'token' => 'required',
         'email' => 'required|email',
         'password' => 'required|min:8|confirmed',
     ]);

     // Reset the password
     $status = Password::reset(
         $request->only('email', 'password', 'password_confirmation', 'token'),
         function ($user, $password) {
             $user->password = Hash::make($password);
             $user->save();
         }
     );

     return $status === Password::PASSWORD_RESET
         ? redirect()->route('login')->with('status', __($status))
         : back()->withErrors(['email' => [__($status)]]);
 }
}
