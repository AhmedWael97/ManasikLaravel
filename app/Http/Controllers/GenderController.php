<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use Auth;
class GenderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Gender_View",['only'=>['index']]);
        $this->middleware("Permission:Gender_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Gender_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Gender_Delete",['only'=>['destroy']]);
    }
    
    public function index(){
        $genders = Gender::get();
        return view('Dashboard.pages.gender.index')->with('genders',$genders);
        }
    
        public function create(){
            return view('Dashboard.pages.gender.create');
        }
    
        public function store(Request $request){
            $gender = new Gender($request->all());
            $gender->user_id = Auth::user()->id; 
            $gender->save();
            return redirect()->route('gender-index')->with('success',translate('Your Gender Added Succfully'));
        }
    
        public function edit($id){
            $gender = Gender::findOrFail($id);
            return view('Dashboard.pages.gender.update')->with('gender',$gender);
        }
    
        public function update(Request $request){
            $gender =  Gender::findOrFail($request->id);
            $gender->update($request->all());
            $gender->save();
            return redirect()->route('gender-index')->with('success', translate('Your Gender Updated Succfully'));
        }
    
        public function destroy($id){
            $gender = Gender::findOrFail($id);
            $gender->delete();
            return redirect()->route('gender-index')->with('success',translate('Your Gender Deleted Succfully'));
        }
}
