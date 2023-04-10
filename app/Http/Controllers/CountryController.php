<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Auth;
class CountryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Country_View",['only'=>['index']]);
        $this->middleware("Permission:Country_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Country_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Country_Delete",['only'=>['destroy']]);
    }
    public function index(){
    $countries = Country::get();
    return view('Dashboard.pages.countries.index')->with('countries',$countries);
    }

    public function create(){
        return view('Dashboard.pages.countries.create');
    }

    public function store(Request $request){
        $country = new Country($request->all());
        $country->user_id = Auth::user()->id;
        $country->save();
        return redirect()->route('country-index')->with('success',translate('Your Country Added Succfully'));
    }

    public function edit($id){
        $country = Country::findOrFail($id);
        return view('Dashboard.pages.countries.update')->with('country',$country);
    }

    public function update(Request $request){
        $country =  Country::findOrFail($request->id);
        $country->update($request->all());
        $country->save();
        return redirect()->route('country-index')->with('success', translate('Your Country Updated Succfully'));
    }

    public function destroy($id){
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect()->route('country-index')->with('success',translate('Your Country Deleted Succfully'));
    }
}
