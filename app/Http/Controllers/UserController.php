<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Job;
use App\Models\Language;
use App\Models\Nationality;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Wallet;
class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Users",['only'=>['index']]);
        $this->middleware("Permission:Users_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Users_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Users_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Users.index')->with([
            'Users' => User::select(['id','name','name_ar','phone','email','is_active'])->with(['roles'])->get(),
        ]);
    }

    public function create() {
        return view('Dashboard.pages.Users.create')->with([
            'Roles' => Role::get(),
            'Genders' => Gender::get(),
            'Countries' => Country::get(),
            'Languages' => Language::get(),
            'Jobs' => Job::get(),
            'Nationalities' => Nationality::get(),
            'Currencies' => Currency::get(),
        ]);
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('Dashboard.pages.Users.edit')->with([
            'User' => $user,
            'Roles' => Role::get(),
            'Genders' => Gender::get(),
            'Countries' => Country::get(),
            'Languages' => Language::get(),
            'Jobs' => Job::get(),
            'Nationalities' => Nationality::get(),
            'Currencies' => Currency::get(),
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required',
            'currency_id' => 'required',
        ]);

        try {
            $user = new User($request->all());
            $user->password = Hash::make($request->password);

            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);

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

            $user->save();

            $wallet = new Wallet([
                'user_id' => $user->id,
                'amount' => 0,
                'currency_id' => $request->currency_id
            ]);

            $wallet->save();
            return redirect()->route('Users')->with('success',translate('Saved Successfully'));
        } catch(Exception $e) {
            return back()->with('warning', $e->getMessage());
        }

    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'role_id' => 'required',
        ]);
         try {
            $user = User::findOrFail($request->user_id);
            $user->passowrd;

            if($request->has('password')) {
                $user->password = Hash::make($request->password);
            }else {
                $old_pass = $user->password;
                $user->update($request->all());
                $user->password = $old_pass;

            }
            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);

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

            $user->save();

            return redirect()->route('Users')->with('success',translate('Saved Successfully'));
        } catch(Exception $e) {
            return back()->with('warning', $e->getMessage());
        }

    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('Users')->with('success',translate('Deleted Successfully'));


    }

    public function view($id) {
        $user = User::findOrFail($id);
        return view('Dashboard.pages.Users.show')->with('User',$user);
    }
}
