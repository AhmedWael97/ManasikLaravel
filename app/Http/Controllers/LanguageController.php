<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use Auth;
class LanguageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Language_View",['only'=>['index']]);
        $this->middleware("Permission:Language_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Language_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Language_Delete",['only'=>['destroy']]);
    }
    public function index(){
        $languages = Language::get();
        return view('Dashboard.pages.language.index')->with('languages',$languages);
    }
    
    public function create(){
        return view('Dashboard.pages.language.create');
    }

    public function store(Request $request){
        $language = new Language($request->all());
        $language->user_id = Auth::user()->id; 
        $language->save();
        return redirect()->route('language-index')->with('success',translate('Your language Added Succfully'));
    }

    public function edit($id){
        $language = Language::findOrFail($id);
        return view('Dashboard.pages.language.update')->with('language',$language);
    }

    public function update(Request $request){
        $language =  Language::findOrFail($request->id)  ;
        $language->update($request->all());
        $language->save();
        return  redirect()->route('language-index')->with('success', translate('Your language Updated Succfully'));
    }

    public function destroy($id){
        $language = Language::findOrFail($id)  ;
        $language->delete();
        return redirect()->route('language-index')->with('success',translate('Your language Deleted Succfully'));
    }
}
