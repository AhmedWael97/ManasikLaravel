<?php

namespace App\Http\Controllers;

use App\Models\ToDoOrder;
use Illuminate\Http\Request;

class RequestToDoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:PaymentTypes",['only'=>['index','accept','refused']]);
    }

    public function index() {
        return view('Dashboard.Pages.OrdersToDo.index')->with('requests', ToDoOrder::get());
    }

    public function accept($req_id) {
        $req = ToDoOrder::findOrFail($req_id);
        $req->is_confirmed = 1;
        $req->save();

        return redirect()->route('RequestToDo')->with('success',translate('Request Saved Successfully'));
    }


    public function refused($req_id) {
        $req = ToDoOrder::findOrFail($req_id);
        $req->delete();
        return redirect()->route('RequestToDo')->with('success',translate('Request Refused Successfully'));
    }
}
