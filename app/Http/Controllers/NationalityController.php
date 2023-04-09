<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nationality;
use Auth;
class NationalityController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Nationality_View",['only'=>['index']]);
        $this->middleware("Permission:Nationality_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Nationality_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Nationality_Delete",['only'=>['destroy']]);
    }
    public function index(){
        $nationalities = Nationality::get();
        return view('Dashboard.pages.nationality.index')->with('nationalities',$nationalities);
    }
    
    public function create(){
        return view('Dashboard.pages.nationality.create');
    }

    public function store(Request $request){
        $nationality = new Nationality($request->all());
        $nationality->user_id = Auth::user()->id; 
        $nationality->save();
        return redirect()->route('nationality-index')->with('success',translate('Your Nationality Added Succfully'));
    }

    public function edit($id){
        $nationality = Nationality::findOrFail($id)  ;
        return view('Dashboard.pages.nationality.update')->with('nationality',$nationality);
    }

    public function update(Request $request){
        $nationality = Nationality::findOrFail($request->id)  ;
        $nationality->update($request->all());
        $nationality->save();
        return redirect()->route('nationality-index')->with('success', translate('Your Nationality Updated Succfully'));
    }

    public function destroy($id){
        $nationality = Nationality::findOrFail($id)  ;
        $nationality->delete();
        return redirect()->route('nationality-index')->with('success',translate('Your Nationality Deleted Succfully'));
    }
}
