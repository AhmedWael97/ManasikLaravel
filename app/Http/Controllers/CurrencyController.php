<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Auth;
class CurrencyController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Currency_View",['only'=>['index']]);
        $this->middleware("Permission:Currency_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Currency_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Currency_Delete",['only'=>['destroy']]);
    }
       public function index(){
        $currencies = Currency::get();
        return view('Dashboard.pages.currency.index')->with('currencies',$currencies);
        }
    
        public function create(){
            return view('Dashboard.pages.currency.create');
        }
    
        public function store(Request $request){
            $currency = new Currency($request->all());
            $currency->user_id = Auth::user()->id;
            $currency->save();
            return redirect()->route('currency-index')->with('success',translate('Your Currency Added Succfully'));
        }
    
        public function edit($id){
            $Currency = Currency::findOrFail($id);
            return view('Dashboard.pages.currency.update')->with('currency',$Currency);
        }
    
        public function update(Request $request){
            $currency =  Currency::findOrFail($request->id);
            $currency->update($request->all());
            $currency->save();
            return redirect()->route('currency-index')->with('success', translate('Your Currency Updated Succfully'));
        }
    
        public function destroy($id){
            $currency = Currency::findOrFail($id);
            $currency->delete();
            return redirect()->route('currency-index')->with('success',translate('Your Currency Deleted Succfully'));
        }
}
