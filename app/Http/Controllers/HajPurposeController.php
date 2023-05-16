<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HajPurpose;
use Illuminate\Support\Facades\Auth;
class HajPurposeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:HajPurpose",['only'=>['index']]);
        $this->middleware("Permission:HajPurpose_Create",['only'=>['create','store']]);
        $this->middleware("Permission:HajPurpose_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:HajPurpose_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.HajPurpose.index')->with('types',HajPurpose::get());
    }
    public function create(){
        return view('Dashboard.pages.HajPurpose.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType = new HajPurpose($request->all());
        $newType->user_id = Auth::user()->id;
        $newType->save();

        return redirect()->route('HajPurpose')->with('success',translate('Saved Successfully'));

    }

    public function edit($id) {
        $HajPurpose = HajPurpose::findOrFail($id);
        return view('Dashboard.pages.HajPurpose.edit')->with('type' , $HajPurpose);
    }

    public function update(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType =  HajPurpose::findOrFail($request->id);
        $newType->update($request->all());
        return redirect()->route('HajPurpose')->with('success',translate('Updated Successfully'));
    }

    public function destroy($id) {
        $newType =  HajPurpose::findOrFail($id);
        $newType->delete();
        return redirect()->route('HajPurpose')->with('success',translate('Deleted Successfully'));
    }
}
