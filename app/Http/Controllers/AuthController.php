<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function register(){
        return View("Auth.register");
    }

    public function login(){
        return View("Auth.login");
    }

    public function forgotPassword(){
        return View("Auth.forgotPassword");
    }

    public function ProfileUser(){
        return View("Profile.profileUser");
    }
}
