<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankBarnch;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Bank_View",['only'=>['index']]);
        $this->middleware("Permission:Bank_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Bank_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Bank_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Auth.login')->with('banks',Bank::get());
    }

    public function create() {
        return view('Auth.login');
    }

    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);
        $newbank = new Bank($request->all());
        $newbank->save();
        if($request->has('branches')) {
            foreach($request->branches as $key=>$branch) {
                $newbankBranch = new BankBarnch([]);
            }
        }
    }




}
