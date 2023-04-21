<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Orders",['only'=>['index','show']]);
        $this->middleware("Permission:Orders_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Orders_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Orders_Delete",['only'=>['destroy']]);
    }


    public function index() {
        return view('Dashboard.pages.orders.index')->with('orders',Order::get());
    }

    public function show($id) {
        return view('Dashboard.pages.orders.orderDetails')->with('order',Order::findOrFail($id));
    }

    public function edit($id) {

    }

}
