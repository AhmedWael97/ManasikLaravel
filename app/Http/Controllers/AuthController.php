<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email',$request->email)->first();
        if($user == null) {
            return redirect('/')->with('message',translate('Email not found'));
        }

        if(count($user->roles) == 0) {
            return redirect('/')->with('message',translate('No permissions for login'));
        }

        if(! $user->roles[0]->hasPermissionTo('Admin_Dashboard_Login')) {
            return redirect('/')->with('message',translate('No permissions for login'));
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/home');
        } else {
            return redirect('/')->with('message','Failed to login');
        }
    }

    public function logout(){
        if(Auth::check()) {
            Auth::logout();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
