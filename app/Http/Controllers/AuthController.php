<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password; // Add this line for the Password facade
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // Valider la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Ajouter le champ 'name'
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Ajout d'une règle de confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer l'utilisateur
        User::create([
            'name' => $request->name, // Inclure le nom
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirection avec message de succès
        return redirect()->route('login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
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
            'phone' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'birthDate' => 'required|date',
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
