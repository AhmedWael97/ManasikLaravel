<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class AuthenticateController extends Controller
{
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                "Status" => 200,
                "MessageEN" => "Sueccssfully Logged",
                "MessageAR" => "تم الدخول بنجاح",
                "Data" => [
                    "User" => Auth::user(),
                    "AccessToken" => "Beare " . Auth::user()->createToken($request->email)->plainTextToken,
                ]
            ]);
        } else {
            return response([
                "Status" => 500,
                "MessageEN" => "Email or Password is wrong",
                "MessageAR" => "كلمة المرور او البريد الالكتروني خطا",
                "Data" => null
            ]);
        }
    }

    public function register() {

    }
}
