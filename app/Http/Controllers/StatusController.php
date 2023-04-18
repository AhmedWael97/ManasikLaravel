<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
class StatusController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Status",['only'=>['index']]);
        $this->middleware("Permission:Status_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Status_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Status_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Status.index')->with('types',Status::get());
    }
    public function create(){
        return view('Dashboard.pages.Status.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType = new Status($request->all());
        $newType->user_id = Auth::user()->id;
        $newType->save();

        return redirect()->route('Status')->with('success',translate('Saved Successfully'));

    }

    public function edit($id) {
        $Status = Status::findOrFail($id);
        return view('Dashboard.pages.Status.edit')->with('type' , $Status);
    }

    public function update(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType =  Status::findOrFail($request->id);
        $newType->update($request->all());
        return redirect()->route('Status')->with('success',translate('Updated Successfully'));
    }

    public function destroy($id) {
        $newType =  Status::findOrFail($id);
        $newType->delete();
        return redirect()->route('Status')->with('success',translate('Deleted Successfully'));
    }
}
