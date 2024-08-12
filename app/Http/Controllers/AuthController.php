<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validators->fails()) {
            return redirect()->route('login')->withErrors($validators)->withInput();
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended(route('projects.index'))->with('message', 'Welcome back!');
        } else {
            return redirect()->route('login')->with('message', 'Login failed! Username/Password is incorrect!');
        }
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    }

}
