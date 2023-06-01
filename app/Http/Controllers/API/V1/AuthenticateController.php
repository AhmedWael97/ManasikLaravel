<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function login(Request $request) {

        $user = User::where('email',$request->email)->orWhere('phone',$request->email)->first();

        if($user == null) {
            return response([
                "Status" => 500,
                "MessageEN" => "Email , phone or Password is wrong",
                "MessageAR" => "كلمة المرور او البريد الالكتروني او رقم الهاتف خطا",
                "Data" => null
            ]);
        }

        if($user != null ) {
        $email = $user->email;
       } else {
        $email = "";
       }

       if(! $user->roles[0]->hasPermissionTo('Mobile_Application_User')) {
        return response([
            "Status" => 500,
            "MessageEN" => "Email , phone or Password is wrong",
            "MessageAR" => "كلمة المرور او البريد الالكتروني او رقم الهاتف خطا",
            "Data" => null
        ]);
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

    public function executer_register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users',
            'password' => 'required|min:10',
            'activity_license_image_path' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048',
            'government_id_path' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048',
            'chamber_of_commerce_registration' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048',
            'commercial_registration_image_path' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048',
            'photo_path' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048',
            'id_number' => 'required|size:11',
            'iban' => 'required',
            'instituation_name' => 'required',
            'bank' => 'required',
            'tax_registration_number' => 'required',
            'agency_address' => 'required',
            'executer_area' => 'required',
            'commercial_registration_no' => 'required',
            'activity_license_number' => 'required',
            'tax_registration_number' => 'required',
            'certificate_registration_tax' => 'required|mimes:jpg,webp,png,jpeg,pdf|max:2048'
        ]);

        if($validator->fails()) {
            return response([
                "Status" => 500,
                "MessageEN" => "Errors With Inputs",
                "MessageAR" => "خطأ في المدخلات",
                "Data" => $validator->errors()
            ]);
        }

        // if(count(explode($request->name, ' ')) < 3) {
        //     return response([
        //         "Status" => 500,
        //         "MessageEN" => "Fullname must be at least 4 from your name",
        //         "MessageAR" => "الاسم كاملا يجب ان يكون علي لاقل رباعي",
        //         "Data" => null
        //     ]);
        // }


        try {
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
           $roles = Role::get();
            foreach($roles as $role) {
                if($role->hasPermissionTo('Executer_Mobile_Application')) {
                    $user->assignRole($role);
                }
            }

            $user->is_active = 0;
            $user->is_confirmed_executer = 0;
            $user->is_allow_notification = 0;
            $user->save();

            if($request->has('photo_path')) {
                $imageName = 'photo_'.time().'.'.$request->photo_path->extension();
                $request->photo_path->move(public_path('images/photos'), $imageName);
                $user->photo_path = $imageName ;
            }

            if($request->has('government_id_path')) {
                $imageName = 'gov_'.time().'.'.$request->government_id_path->extension();
                $request->government_id_path->move(public_path('images/govs'), $imageName);
                $user->government_id_path = $imageName ;
            }

            if($request->has('activity_license_image_path')) {
                $imageName = 'act_'.time().'.'.$request->activity_license_image_path->extension();
                $request->activity_license_image_path->move(public_path('images/act'), $imageName);
                $user->activity_license_image_path = $imageName ;
            }

            if($request->has('commercial_registration_image_path')) {
                $imageName = 'comm_'.time().'.'.$request->commercial_registration_image_path->extension();
                $request->commercial_registration_image_path->move(public_path('images/comm'), $imageName);
                $user->commercial_registration_image_path = $imageName ;
            }

            if($request->has('chamber_of_commerce_registration')) {
                $imageName = 'chamber_'.time().'.'.$request->chamber_of_commerce_registration->extension();
                $request->chamber_of_commerce_registration->move(public_path('images/chamber'), $imageName);
                $user->chamber_of_commerce_registration = $imageName ;
            }

            if($request->has('certificate_registration_tax')) {
                $imageName = 'crt_'.time().'.'.$request->certificate_registration_tax->extension();
                $request->certificate_registration_tax->move(public_path('images/crt'), $imageName);
                $user->certificate_registration_tax = $imageName ;
            }

            //


            $user->save();

            $wallet = new Wallet([
                'user_id' => $user->id,
                'amount' => 0,
                'currency_id' => 1,
            ]);

            $wallet->save();

            return response([
                "Status" => 200,
                "MessageEN" => "Sucess, Your request will review by our team and will notify you",
                "MessageAR" => "تم بنجاح , سيتم مراجعة طلبكم و اعلامكم قريبا",
                "Data" => null
            ]);
            //return redirect()->route('Users')->with('success',translate('Saved Successfully'));
        } catch(Exception $e) {
            $user->delete();
            return response([
                "Status" => 500,
                "MessageEN" => "Execption error detect",
                "MessageAR" => "حطا في استقبال الطلب",
                "Data" => $e->getMessage(),
            ]);
            //return back()->with('warning', $e->getMessage());
        }
    }

    public function executer_login(Request $request) {

       $user = User::where('email',$request->email)->orWhere('phone',$request->email)->first();

       if($user == null) {
            return response([
                "Status" => 500,
                "MessageEN" => "Email , phone or Password is wrong",
                "MessageAR" => "كلمة المرور او البريد الالكتروني او رقم الهاتف خطا",
                "Data" => null
            ]);
        }

       if($user != null ) {
            $email = $user->email;
       } else {
            $email = "";
       }

       if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return response([
                "Status" => 500,
                "MessageEN" => "Wrong Permission to login",
                "MessageAR" => "ليس لديك الصلاحيات",
                "Data" => null
            ]);
        }



        if(Auth::attempt(['email' => $email, 'password' => $request->password])) {

            if($user->is_active == 0) {
                Auth::logout();
                return response([
                    "Status" => 500,
                    "MessageEN" => "Please wait till admin activate your account",
                    "MessageAR" => "لم يتم تفعيل حسابك ، من فضلك إنتظر المسئول للموافقة علي حسابك",
                    "Data" => null
                ]);
            }



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
}
