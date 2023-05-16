<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // $this->middleware("Permission:Currency",['only'=>['index']]);
        // $this->middleware("Permission:Currency_Create",['only'=>['create','store']]);
        // $this->middleware("Permission:Currency_Update",['only'=>['edit','update']]);
        // $this->middleware("Permission:Currency_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Wallets.index')->with([
            'Wallets' => Wallet::get(),
        ]);
    }
}
