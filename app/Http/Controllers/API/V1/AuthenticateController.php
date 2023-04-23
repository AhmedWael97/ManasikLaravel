<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthenticateController extends Controller
{
    public function login(Request $request) {

        $user = User::where('email',$request->email)->orWhere('phone',$request->email)->first();
       if($user != null ) {
        $email = $user->email;
       } else {
        $email = "";
       }

        if(Auth::attempt(['email' => $email, 'password' => $request->password])) {
            return response([
                "Status" => 200,
                "MessageEN" => "Sueccssfully Logged",
                "MessageAR" => "تم الدخول بنجاح",
                "Data" => [
                    "User" => Auth::user(),
                    "AccessToken" => "Bearer " . Auth::user()->createToken($request->email)->plainTextToken,
                ]
            ]);
        } else {
            return response([
                "Status" => 500,
                "MessageEN" => "Email , phone or Password is wrong",
                "MessageAR" => "كلمة المرور او البريد الالكتروني او رقم الهاتف خطا",
                "Data" => null
            ]);
        }
    }

    public function register(Request $request) {

        if(User::where('email',$request->email)->orWhere('phone',$request->email)->first()) {
            return response([
                "Status" => 500,
                "MessageEN" => "Email , phone or is taken",
                "MessageAR" => "البريد الالكتروني او الهاتف مستخدمين من قبل",
                "Data" => null
            ]);
        }
        if( ! $request->has('password') && $request->password == null) {
            return response([
                "Status" => 500,
                "MessageEN" => "Password are required",
                "MessageAR" => "كلمة المرور الزامية",
                "Data" => null
            ]);
        }
        $newUser = new User([
            'phone' => $request->email,
            'email' => rand(999,9999999999).'@rand.com',
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'name_ar' => $request->name,
            'country_id' => $request->has('country') ? $request->country : 1,
        ]);
        $newUser->save();

        $roles = Role::get();
        foreach($roles as $role) {
            if($role->hasPermissionTo('Mobile_Application_User')) {
                $newUser->assignRole($role);
            }
        }



        $newWallet = new Wallet([
            'user_id' => $newUser->id,
            'currency_id' => 1,
            'amount' => 0,
        ]);
        $newWallet->save();
        if(Auth::attempt(['email' => $newUser->email, 'password' => $request->password])) {
            return response([
                "Status" => 200,
                "MessageEN" => "Sueccssfully Logged",
                "MessageAR" => "تم الدخول بنجاح",
                "Data" => [
                    "User" => Auth::user(),
                    "AccessToken" => "Bearer " . Auth::user()->createToken($newUser->email)->plainTextToken,
                ]
            ]);
        } else {
            return response([
                "Status" => 500,
                "MessageEN" => "Email , phone or Password is wrong",
                "MessageAR" => "كلمة المرور او البريد الالكتروني او رقم الهاتف خطا",
                "Data" => null
            ]);
        }
    }
}
