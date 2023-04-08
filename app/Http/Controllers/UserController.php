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
class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Users",['only'=>['index']]);
        $this->middleware("Permission:Users_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Users_Edit",['only'=>['edit','update']]);
        $this->middleware("Permission:Users_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Users.index')->with([
            'Users' => User::select(['id','name','name_ar','phone','email'])->get(),
        ]);
    }

    public function create() {
        return view('Dashboard.pages.Users.create')->with([
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
        return view('Dashboard.pages.Users.create')->with([
            'User' => $user,
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
            'password' => 'requied',
        ]);
        try {
            $user = new User($request->all());
            $user->save();

            if($request->has('photo_path')) {

            }
        } catch(Exception $e) {

        }

    }
}
