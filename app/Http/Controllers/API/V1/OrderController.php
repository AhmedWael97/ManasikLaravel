<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentType;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use App\Models\ApplicationResponse;
use App\Models\User;
use App\Models\OrderDetailStep;
use App\Models\ServiceStep;
use App\Models\ToDoOrder;
use DB;
use \App\Models\DetailStepRequest;
use App\Models\ServiceKfaratChoice;

class OrderController extends Controller
{
    public $response;
    public $paymentController;
    public function __construct()
    {
        $this->response = new ApplicationResponse();
        $this->paymentController = new PaymentController();
    }
    public function store(Request $request) {
        try {
            if($request->user() == null) {
                return $this->response->unAuthroizeResponse();
            }
            if(! $request->has('paymentType') && ! $request->has('isWallet')) {
                return $this->response->ErrorResponse('No payment methods specified');
            }
            $isWallet = $request->isWallet;

            if($request->paymentType == null && $isWallet == 1) {
                $paymentType = PaymentType::where('id', 5)->select('id')->first();
            } else {
                $paymentType = PaymentType::where('id',$request->paymentType)->select('id')->first();
            }



            if($paymentType != null) {
                $payment_type_id = $paymentType->id;
            } else {
                return $this->response->ErrorResponse("Invalid Payment Type");
            }

            if($request->has('cart') && count($request->cart) >= 1) {
                $orders = [];
                foreach($request->cart as $requestOrder) {

                    if( ! $requestOrder['services'] && ! count($requestOrder['services']) >= 1 ) {
                        return $this->response->ErrorResponse("Invalid Child Services");
                    }



                    $newOrder = new Order([
                        'user_id' => $request->user()->id,
                        'main_service_id' => $requestOrder['mainServiceId'],
                        'payment_type_id' => $payment_type_id,
                        'payment_status_id' => 1,
                        'order_code' => rand(9999,999999),
                        'order_status_id' => 1,
                        'price' => 0,
                        'currency_id' => 1,
                        'is_from_wallet' => $isWallet,

                    ]);
                    $newOrder->save();
                    $price = 0;
                    $points = 0;
                    foreach($requestOrder['services'] as $minService) {

                        $service = Service::where('id',$minService['ServiceId'])->first();
                        $price += $service->price;
                        $points += $service->earning_points;
                        $executer_id = null ;
                        if($service->price == 0) {
                            $executer_id = $request->user()->id;
                        }
                        $newOrderDetails = new OrderDetail([
                            'order_id' => $newOrder->id,
                            'service_id' => $service->id,
                            'order_status_id' => $newOrder->order_status_id,
                            'full_name' => $minService['name'],
                            'currency_id' => $newOrder->currency_id,
                            'price' => $service->price,
                            'executer_price' => $service->executer_price,
                            'no_of_kfara' => $minService['kfaraCount'] ??  null ,
                            'kfarat_choice_id' => $minService['KfaraChoiceId'] ?? null,
                            'purpose_hag_id' => $minService['HajPurpose'] ?? null,
                            'executer_id' => $executer_id,
                        ]);
                        $newOrderDetails->save();
                    }

                    $newOrder->price = $price;
                    $newOrder->save();

                    $user = User::where('id',$request->user()->id)->select('id','points')->first();
                    $user->points += $points;
                    $user->save();

                    // payments
                    if( $paymentType->is_internal == 1 && $isWallet == 1) {
                        $paymentRequest = [
                            'order' => $newOrder,
                            'user' => $request->user(),
                        ];
                        $this->paymentController->payWithWallet($paymentRequest);
                    } else if ($paymentType->is_internal == 1 && $isWallet == 0) {
                        $paymentRequest = [
                            'order' => $newOrder,
                            'user' => $request->user(),
                        ];
                        $this->paymentController->payWithPrize($paymentRequest);
                    }
                    array_push($orders,$newOrder->id);
                }


                return $this->response->successResponse('Order',Order::whereIn('id',$orders)->get());
            } else {
                return $this->response->ErrorResponse('No Services Selected');
            }



            return $this->successResponse('Order',$newOrder);

        } catch (Exception $e) {
            $newOrder->delete();
            return $this->response->ErrorResponse($e->getMessage());
        }
    }

    public function orderDetails(Request $request,$id) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }


        $order = Order::where(['user_id'=>$request->user()->id, 'id'=>$id])->first();
        if($order == null) {
            return $this->response->notFound('Order Not Found');
        }
        $orderDetails = OrderDetail::where('order_id',$order->id)
        ->select('order_id','full_name','purpose_hag_id','kfarat_choice_id','service_id',DB::raw('count(*) as total'),'order_status_id')
        ->groupBy('service_id','full_name','purpose_hag_id','kfarat_choice_id', 'order_id','order_status_id')
        ->with('order.user','service','hajPurpose','KfaraChoice','status')->get();
        return $this->response->successResponse('OrderDetail',$orderDetails);

    }

    public function orderDetailStep(Request $request,$order_id, $service_id) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $order = Order::where(['user_id'=>$request->user()->id, 'id'=>$order_id])->first();
        if($order == null) {
            return $this->response->notFound('Order Not Found');
        }

        $orderDetail = OrderDetail::where(['order_id'=>$order_id,'service_id'=>$service_id])->first();
        if($orderDetail == null) {
            return $this->response->notFound('Order Detail Not Found');
        }

        if(count($orderDetail->steps) == 0) {
            $service = Service::where('id',$service_id)->first();
            if($service == null) {
                return $this->response->notFound('No Service Found');
            }
            foreach($service->steps as $step) {
                $newOrderDetailStep = new OrderDetailStep([
                    'detail_id' => $orderDetail->id,
                    'service_step_id' => $step->id,
                    'step_status_id' => 1,
                ]);
                $newOrderDetailStep->save();
            }
        }


        $steps = OrderDetailStep::where('detail_id',$orderDetail->id)->with(['status','step'])->get();


        return $this->response->successResponse('OrderDetailStep',$steps);
    }

    public function myOrders(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        return $this->response->successResponse('Order',Order::where('user_id',$request->user()->id)->with('status','mainService')->get());
    }

    public function cancelMyOrder(Request $request,$order_id) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $order = Order::where(['user_id' => $request->user()->id, 'id' => $order_id])->first();
        if($order == null) {
            return $this->response->notFound('Order Not Found');
        }

        if($order->excuter_id != null) {
            return $this->response->errorResponse('You can not cancel order already started');
        }

        $order->delete();
        return $this->response->successResponse('Data',null);
    }

    public function executer_avaliavble_orders (Request $request) {


        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }
        $user = User::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $excludedServices = ServiceKfaratChoice::select('service_id')->distinct('service_id')->get()->pluck('service_id');

        $orders = OrderDetail::where('executer_id',null)
        ->whereNotIn('service_id',$excludedServices)
        ->where('price','<>', 0)
        ->orderBy('created_at','desc')->with([
            'service', 'order' => function($query) {
                $query->with('user');
            }
        ])->paginate(15);

        return $this->response->successResponse('Order',$orders);

    }

    public function request_to_take_order (Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user())->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $order = OrderDetail::where('id',$request->order_id)->where('executer_id',null)->first();
        if($order == null) {
            return $this->response->errorMessage('Order Already Taken');
        }


        // $order haj test
        if($order->hajPurpose != null ) {
            $previousOrders = OrderDetail::
            where([
                'executer_id'=>$user->id,
                ['purpose_haj_id' , '<>' , null],
                ['order_status_id' , '<>' , 11],
                ])
            ->WhereYear('created_at',Date('YY'))->count();
            if($previousOrders >= 1) {
                return $this->response->errorMessage('Already have a haj request');
            }
        } else {
            $previousOrders = OrderDetail::
            where([
                'executer_id'=>$user->id,
                ['purpose_haj_id' , null],
                ['order_status_id' , '<>' , 11],
                ])
            ->WhereYear('created_at',Date('YY'))->count();
            if($previousOrders >= 3) {
                return $this->response->errorMessage('Already have a 3 Umra requests');
            }
        }

        $newToDo = new ToDoOrder([
            'executer_id' => $request->user()->id,
            'order_detail_id' => $request->order_id,
            'is_confirmed' => 1,
        ]);
        $newToDo->save();

        $order->executer_id = $request->user()->id;
        $order->order_status_id = 6;

        // actual date

        // required date

        $order->save();

        return $this->response->successResponse('ToDoOrder',$newToDo);
    }

    public function my_to_do_orders(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user())->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $todo = OrderDetail::where('executer_id',$request->auth()->id)
        ->with('order','hajPurpose','KfaraChoice','steps','orders','service')->get();
        return $this->response->successResponse('ToDoOrder',$todo);
    }



    // user
    public function my_order_steps(Request $request ,$order_detail_id) {

        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user()->id)->first();

        if(! $user->roles[0]->hasPermissionTo('Mobile_Application_User')) {
            return $this->response->noPermission();
        }

        $order = OrderDetail::where('id',$order_detail_id)->with('order','steps')->first();

        if($order->order->user_id != $user->id) {
            return $this->response->noPermission();
        }

        if($order->executer_id == null) {
            return $this->response->errorMessage('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->errorMessage('Order is' . $order->status->name_en);
        }

        $steps = OrderDetailStep::where('detail_id', $order->id)->with('status','step')->get();;
        return $this->response->successMessage('Steps' , $steps);
    }

    public function ask_image(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user()->id)->first();

        if(! $user->roles[0]->hasPermissionTo('Mobile_Application_User')) {
            return $this->response->noPermission();
        }

        $order = OrderDetail::where('id',$request->order_detail_id)->with('order','steps')->first();

        if($order->order->user_id != $user->id) {
            return $this->response->noPermission();
        }

        if($order->executer_id == null) {
            return $this->response->errorMessage('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->errorMessage('Order status is' . $order->status->name_en);
        }

        $step = OrderDetailStep::where('id',$request->step_id)->first();
        if($step->end_in == null) {
            return $this->response->errorMessage('Step is already ended');
        }

        if($step->start_in == null) {
            return $this->response->errorMessage('Step Not Statred Yet');
        }

        // create request to ask image
        $newRequest = new DetailStepRequest([
            'type' => 0,
            'order_detail_step_id' => $step->id,
        ]);
        $newRequest->save();

        return $this->successResponse('DetailRequest',$newRequest);
    }

    public function ask_live_location(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user()->id)->first();

        if(! $user->roles[0]->hasPermissionTo('Mobile_Application_User')) {
            return $this->response->noPermission();
        }

        $order = OrderDetail::where('id',$request->order_detail_id)->with('order','steps')->first();

        if($order->order->user_id != $user->id) {
            return $this->response->noPermission();
        }

        if($order->executer_id == null) {
            return $this->response->errorMessage('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->errorMessage('Order is' . $order->status->name_en);
        }

        $step = OrderDetailStep::where('id',$request->step_id)->first();
        if($step->end_in == null) {
            return $this->response->errorMessage('Step is already ended');
        }

        if($step->start_in == null) {
            return $this->response->errorMessage('Step Not Statred Yet');
        }

        // create request to live Location
        $newRequest = new DetailStepRequest([
            'type' => 1,
            'order_detail_step_id' => $step->id,
        ]);
        $newRequest->save();

        return $this->successResponse('DetailRequest',$newRequest);
    }

    // end users

    // executers
    public function startSteps(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user())->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $order = Order::where(['id' => $request->order_id , 'executer_id' => $request->user()->id])->first();
        if($order == null) {
            return $this->response->errorMessage('Error in order');
        }

        // check step needed and check if it ended or not and if old steps is already done or not !!

        $step = ServiceStep::where(['service_id' => $request->service_id , 'id' => $request->step_id])->first();
        if($step == null) {
            return $this->response->errorMessage('Error In Step');
        }

        //
        $orderStep = OrderDetailStep::where('id',$request->step_id)->first();
        if($orderStep == null) {
            return $this->response->errorMessage('Error In Step');
        }
        if($orderStep->startIn != null) {
            return $this->response->errorMessage('It is already started');
        }


    }

    public function end_step(Request $request) {

    }

    public function send_image(Request $request) {

    }

    public function send_live_location(Request $request) {

    }
    //end executers
}
