<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // $this->middleware("permission:Cars View",['only'=>['index']]);
        // $this->middleware("permission:Cars Create",['only'=>['create','store']]);
        // $this->middleware("permission:Cars Edit",['only'=>['edit','update']]);
        // $this->middleware("permission:Cars Delete",['only'=>['destroy']]);
    }

    public function home() {
        return view('Dashboard.pages.home');
    }
}
