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
use App\Models\Executer;

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
            if(! $request->has('paymentTypeId') && ! $request->has('isWallet')) {
                return $this->response->ErrorResponse('No payment methods specified');
            }


            $isWallet = $request->isWallet;

            if($request->paymentTypeId == 0 && $isWallet == 1) {
                $paymentType = PaymentType::where('id', 5)->select('id','is_internal')->first();
            } else if ($request->paymentTypeId == 0 && $isWallet == 0) {

                if($request->has('Payment')) {

                    $type = $request->Payment['type'];
                    if($type == null) {
                        return $this->response->ErrorResponse("Invalid Payment Type");
                    }

                    $paymentType = PaymentType::where('name_en','like', '%'.$type.'%')->select('id','is_internal')->first();
                    if($paymentType == null) {
                            return $this->response->ErrorResponse("Invalid Payment Type");
                        }
               } else {
                    return $this->response->ErrorResponse("Invalid Payment Type");
               }

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

                    // if(reach_limit_for_max_limit($requestOrder['mainServiceId'])) {

                    // }
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
                    } else if ($paymentType->is_internal == 0 && $isWallet == 0) {
                        $paymentRequest = [
                            'order' => $newOrder,
                            'user' => $request->user(),
                        ];
                        $this->paymentController->payWithOnlineGateways($paymentRequest);
                    }
                    array_push($orders,$newOrder->id);
                }


                return $this->response->successResponse('Order',Order::whereIn('id',$orders)->get());
            } else {
                return $this->response->ErrorResponse('No Services Selected');
            }





        } catch (Exception $e) {
            // $newOrder->delete();
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
        ->select('id','order_id','full_name','purpose_hag_id','kfarat_choice_id','service_id',DB::raw('count(*) as total'),'order_status_id')
        ->groupBy('id','service_id','full_name','purpose_hag_id','kfarat_choice_id', 'order_id','order_status_id')
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
        $user = Executer::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $excludedServices = ServiceKfaratChoice::select('service_id')->distinct('service_id')->get()->pluck('service_id');


        $orders = DB::table('order_details')
        ->whereNotIn('order_details.service_id',$excludedServices)
        ->where('executer_id','=', null)
        ->join('orders','orders.id','=','order_details.order_id')
        ->where('orders.payment_status_id','=',11)
        ->join('services','services.id' ,'=' ,'order_details.service_id')
        ->leftJoin('haj_purposes','order_details.purpose_hag_id','=','haj_purposes.id')
        ->join('users','users.id','=','orders.user_id')
        ->select('order_details.id as id','order_details.executer_price as reward','services.name_ar as service_name_ar','services.name_en as service_name_en','haj_purposes.name_ar as haj_purpose_name_ar','haj_purposes.name_en as haj_purpose_name_en' ,'users.name_ar as requester_name_ar' ,'users.name as requester_name_en')->get();



        return $this->response->successResponse('Order',$orders);

    }

    public function request_to_take_order (Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = Executer::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }




        $order = OrderDetail::where('id',$request->order_id)->where('executer_id',null)->first();
        if($order == null) {
            return $this->response->ErrorResponse('Order Already Taken');
        }


        // $order haj test
        if($order->hajPurpose != null ) {

            $previousOrders = OrderDetail::
            where([
                'executer_id'=>$user->id,
                ['purpose_hag_id' , '<>' , null],
                ['order_status_id' , '<>' , 11],
                ])
            ->WhereYear('created_at',Date('YY'))->count();
            if($previousOrders >= 1) {
                return $this->response->ErrorResponse('Already have a haj request');
            }
        } else {
            $previousOrders = OrderDetail::
            where([
                'executer_id'=>$user->id,
                ['purpose_hag_id' , null],
                ['order_status_id' , '<>' , 11],
                ])
            ->WhereYear('created_at',Date('YY'))->count();
            if($previousOrders >= 3) {
                return $this->response->ErrorResponse('Already reach a 3 Umra requests');
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
        $order->required_date = $request->start_date;
        // required date
        $order->save();

        return $this->response->successResponse('ToDoOrder',$newToDo);
    }

    public function my_to_do_orders(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = Executer::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        // $todo = OrderDetail::where('executer_id',$request->user()->id)
        // ->with('order','hajPurpose','KfaraChoice','steps','steps.step','service')->get();

        $todo = DB::table('order_details as od')
            ->where('od.executer_id',$request->user()->id)
            ->join('orders as o','od.order_id','=','o.id')
            ->leftJoin('haj_purposes as  hp','hp.id','=','od.purpose_hag_id')
            ->join('services as s' ,'s.id' , '=' , 'od.service_id')
            ->join('users as u','u.id' ,'=' ,'o.user_id')
            ->select('od.id'
                ,'s.id as service_id'
                ,'s.name_en as service_name_en'
                ,'s.name_ar as service_name_ar'
                ,'od.full_name'
                ,'od.execution_date'
                ,'od.required_date'
                ,'od.executer_price as earnings'
                ,'u.name as username_en'
                ,'u.name_ar as username_ar'
                ,'hp.name_ar as haj_purpose_ar'
                ,'hp.name_ar as haj_purpose_en'
            )->get();

        foreach($todo as $key=>$orderDetail) {
            $lastStep = OrderDetailStep::where('detail_id',$orderDetail->id)->select('detail_id','service_step_id','start_in','end_in')->with([
                'step' => function($query) {
                    $query->select('id','name_ar as step_name_ar' ,'name_en as step_name_en' ,'max_time_in_minute' ,'min_time_in_minute');
                }
            ])->orderBy('id','desc')->first();
            if($lastStep == null) {
                break;
            }
            if($lastStep->end_in == null) {
                $todo[$key]->steps = [
                    'need_to_finish' => 1,
                    'need_to_start' => 0,
                    'step' => $lastStep,
                ];
                break;
            } else {
                $countOfServicesSteps = ServiceStep::where('service_id',$orderDetail->service_id)
                                        ->select('service_id','name_ar as step_name_ar' ,'name_en as step_name_en' ,'max_time_in_minute' ,'min_time_in_minute')->get();
                $countOfDoneSteps = OrderDetailStep::where('detail_id',$orderDetail->id)->count();
                if(count($countOfServicesSteps) == $countOfDoneSteps) {
                    $todo[$key]->steps = [
                        'need_to_finish' => 0,
                        'need_to_start' => 0,
                        'step' => null,
                    ];
                    break;
                } else {
                    $todo[$key]->steps = [
                        'need_to_finish' => 0,
                        'need_to_start' => 1,
                        'step' => $countOfServicesSteps[$countOfDoneSteps],
                    ];
                    break;
                }
            }
        }

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
            return $this->response->ErrorResponse('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->ErrorResponse('Order is' . $order->status->name_en);
        }

        $steps = OrderDetailStep::where('detail_id', $order->id)->with('status','step')->get();;
        return $this->response->successResponse('Steps' , $steps);
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
            return $this->response->ErrorResponse('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->ErrorResponse('Order status is' . $order->status->name_en);
        }

        $step = OrderDetailStep::where('id',$request->step_id)->first();
        if($step->end_in == null) {
            return $this->response->ErrorResponse('Step is already ended');
        }

        if($step->start_in == null) {
            return $this->response->ErrorResponse('Step Not Statred Yet');
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
            return $this->response->ErrorResponse('No Steps Found');
        }

        if(in_array($order->order_status_id,[1,2,7,9,10])) {
            return $this->response->ErrorResponse('Order is' . $order->status->name_en);
        }

        $step = OrderDetailStep::where('id',$request->step_id)->first();
        if($step->end_in == null) {
            return $this->response->ErrorResponse('Step is already ended');
        }

        if($step->start_in == null) {
            return $this->response->ErrorResponse('Step Not Statred Yet');
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

        $user = Executer::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }
        $order = OrderDetail::where(['id' => $request->order_id , 'executer_id' => $request->user()->id])->first();
        if($order == null) {
            return $this->response->ErrorResponse('Error in order');
        }

        // Check Services Step

        $steps = ServiceStep::where(['service_id' => $order->service_id])->select('id','service_id','name_en','name_ar','min_time_in_minute','max_time_in_minute')->get();
        if($steps == null || count($steps) == 0) {
            return $this->response->ErrorResponse('Error In Step');
        }

        $currentStepInOrder = $order->steps->count();


        if(count($steps) == ($currentStepInOrder)) {
            return $this->response->ErrorResponse('Steps Ended');
        }


        if(count($order->steps) > 0) {
            if($order->steps[count($order->steps) -1]->end_in == null ) {
                return $this->response->ErrorResponse('Please end step first');
            }
        }

        $nextStep = $steps[$currentStepInOrder];
        $nextStepInOrder = new OrderDetailStep();
        $nextStepInOrder->detail_id = $order->id;
        $nextStepInOrder->service_step_id = $nextStep->id;
        $nextStepInOrder->start_in = Date('d-m-Y h:i A');
        $nextStepInOrder->step_status_id = 3;
        $nextStepInOrder->save();
        //

        $order->order_status_id = 3;
        $order->execution_date = $nextStepInOrder->start_in;
        $order->save();

        $steps[$currentStepInOrder]->min_end_date = Date('d-m-Y h:i A', strtotime( $nextStepInOrder->start_in . ' + ' . $steps[$currentStepInOrder]->min_time_in_minute .' minutes'));
        $steps[$currentStepInOrder]->max_end_date = Date('d-m-Y h:i A', strtotime( $nextStepInOrder->start_in . ' + ' . $steps[$currentStepInOrder]->max_time_in_minute .' minutes'));
        $steps[$currentStepInOrder]->start_in = $nextStepInOrder->start_in;
        return $this->response->successResponse('Step' , $steps[$currentStepInOrder]);

    }

    public function end_step(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = Executer::where('id',$request->user()->id)->first();

        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }
        $order = OrderDetail::where(['id' => $request->order_id , 'executer_id' => $request->user()->id])->first();
        if($order == null) {
            return $this->response->ErrorResponse('Error in order');
        }

        $steps = ServiceStep::where(['service_id' => $order->service_id])->select('id','service_id','name_en','name_ar','min_time_in_minute','max_time_in_minute')->get();
        if($steps == null || count($steps) == 0) {
            return $this->response->ErrorResponse('Error In Step');
        }

        if(count($order->steps) == 0) {
            return $this->response->ErrorResponse('No step is started');
        }

        $orderCurrentStep = $order->steps[count($order->steps)-1];
        if($orderCurrentStep->end_in != null ) {
            return $this->response->errorResponse('No Step Started');
        }

        // $currentDate = Date('d-m-Y h:i A');
        // $minMumEndDate = Date('d-m-Y h:i A',strtotime($orderCurrentStep->start_date . ' +' . $orderCurrentStep->step->min_time_in_minutes . ' minutes'));
        // if($currentDate > $minMumEndDate) {
        //     return $this->response->errorResponse('Cannot end step now');
        // }

        $orderCurrentStep->end_in = Date('d-m-Y h:i A');
        $orderCurrentStep->step_status_id = 11;
        $orderCurrentStep->save();

        if(count($order->steps) == count($steps)) {
            return $this->response->successResponse('step',null);
        }


        return $this->response->successResponse('step',$steps[count($order->steps)]);
    }


    //executer
    public function send_image(Request $request) {
        // order_id | step_id
    }

    public function send_live_location(Request $request) {

    }
    //end executers
}
