<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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
            }        
        }
    
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


    public function profileUser(){
        $user = Auth::user();
        return view("Profile.profileUser", compact('user'));
    }

    public function profileUserNav(){
        $user = Auth::user();
        return view("Profile.profilenav", compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:8',
            'address' => 'nullable|string|max:255',
            'birthDate' => 'nullable|date',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->birthDate = $request->input('birthDate');
        
        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    public function updateImage(Request $request)
    {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif',
            ]);

            $user = Auth::user();

            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::delete('public/' . $user->image);
                }

                $path = $request->file('image')->store('profiles', 'public');

                $user->image = $path;
                $user->save();
            }

            return redirect('/profile');
    }


    public function getUsers(){

        $users = User::where('role' , 'user')->get(); 
        return response()->json($users);
    }
}