<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PaymentTypeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:PaymentTypes",['only'=>['index']]);
        $this->middleware("Permission:PaymentTypes_Create",['only'=>['create','store']]);
        $this->middleware("Permission:PaymentTypes_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:PaymentTypes_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.paymentTypes.index')->with('types',PaymentType::get());
    }
    public function create(){
        return view('Dashboard.pages.paymentTypes.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType = new PaymentType($request->all());
        $newType->user_id = Auth::user()->id;
        $newType->save();

        return redirect()->route('PaymentTypes')->with('success',translate('Saved Successfully'));

    }

    public function edit($id) {
        $paymentType = PaymentType::findOrFail($id);
        return view('Dashboard.pages.paymentTypes.edit')->with('type' , $paymentType);
    }

    public function update(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        $newType =  PaymentType::findOrFail($request->id);
        $newType->update($request->all());
        return redirect()->route('PaymentTypes')->with('success',translate('Updated Successfully'));
    }

    public function destroy($id) {
        $newType =  PaymentType::findOrFail($id);
        $newType->delete();
        return redirect()->route('PaymentTypes')->with('success',translate('Deleted Successfully'));
    }
}
