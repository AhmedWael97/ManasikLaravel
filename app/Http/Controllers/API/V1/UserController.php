<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $response;
    public $paymentController;
    public function __construct()
    {
        $this->response = new ApplicationResponse();
    }

    public function getMyInfo(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }
        $user = User::where('id',$request->user()->id)->select('id','name','name_ar','email','phone','country_id')->with('country','wallet.currency')->first();
        return $this->response->successResponse('User',$user);
    }

    public function UpdateMyInfo(Request $request) {

        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user()->id)->first();

        if($request->has('email') && $request->email != null) {
            if(User::where('email',$request->email)->first()) {
                return $this->response->ErrorResponse('Email already taken');
            }
            $user->email = $request->email;
        }
        if($request->has('phone') && $request->phone != null) {
            if(User::where('phone',$request->phone)->first()) {
                return $this->response->ErrorResponse('Phone already taken');
            }
            $user->phone = $request->phone;
        }
        if($request->has('password') && $request->has('password_confirmation') && $request->password != null && $request->password_confirmation != null ) {
            if($request->password != $request->password_confirmation) {
                return $this->response->errorMessage('password and password confirmation not matched');
            }

            if(strlen($request->password) < 8) {
                return $this->response->errorMessage('Password must more than 8 letters or numbers');
            }

            $user->password = Hash::make($user->password);
        }
        if($request->has('name') && $request->name != null) {
            $user->name = $request->name;
        }
        if($request->has('name_ar') && $request->name_ar != null) {
            $user->name_ar = $request->name_ar;
        }

        $user->save();
        return $this->response->successResponse('User',$user->select('id','name','name_ar','email','phone')->first());
    }

}
