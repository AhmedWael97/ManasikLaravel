<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailStep;
use App\Models\ServiceStep;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
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

        $roles_ids =  DB::table('role_has_permissions')->where('permission_id',68)->select('role_id')->get()->pluck('role_id');
        $users_ids = DB::table('model_has_roles')->whereIn('role_id',$roles_ids)->select('model_id')->get()->pluck('model_id');

        $executers = User::whereIn('id',$users_ids)->get();


        return view('Dashboard.pages.orders.orderDetails')->with([
            'order' => Order::findOrFail($id),
            'statuses' => Status::get(),
            'executers' => $executers,
        ]);
    }

    public function ChangeStatus(Request $request) {
        $order = Order::findOrFail($request->order_id);
        $status = Status::findOrFail($request->status_id);

        $order->payment_status_id = $status->id;
        $order->save();

        return redirect()->route('Orders-Show',$order->id)->with('success',translate('Status Changed Successfully'));
    }

    public function AssignExecuter(Request $request) {
        $orderDetails = OrderDetail::findOrFail($request->orderDetail_id);
        $executer = User::findOrFail($request->executer_id);

        $orderDetails->executer_id = $executer->id;
        $orderDetails->save();

        if(count($orderDetails->steps) == 0) {
            $serviceSteps = ServiceStep::where('service_id',$orderDetails->service_id)->select('id')->get();
            foreach($serviceSteps as $step) {
                $OrderDetailsStep = new OrderDetailStep([
                    'detail_id' => $orderDetails->id,
                    'service_step_id' => $step->id,
                    'step_status_id' => 1,
                ]);
                $OrderDetailsStep->save();
            }

        }
        //notify Executer

        return redirect()->route('Orders-Show',$orderDetails->order_id)->with('success',translate('Executer Assigned successfully and will be notified'));

    }

    public function edit($id) {

    }

}
