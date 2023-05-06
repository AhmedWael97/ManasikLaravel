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
use App\Models\ToDoOrder;
use DB;

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
                        'currency_id' => $request->user()->wallet->currency_id,
                        'is_from_wallet' => $isWallet,

                    ]);
                    $newOrder->save();
                    $price = 0;
                    $points = 0;
                    foreach($requestOrder['services'] as $minService) {

                        $service = Service::where('id',$minService['ServiceId'])->first();
                        $price += $service->price;
                        $points += $service->earning_points;
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

                    return $this->response->successResponse('Order',$newOrder);
                }
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
        ->select('order_id','full_name','purpose_hag_id','kfarat_choice_id','service_id',DB::raw('count(*) as total'))
        ->groupBy('service_id','full_name','purpose_hag_id','kfarat_choice_id', 'order_id')
        ->with('order.user','service','hajPurpose','KfaraChoice')->get();
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

        return $this->response->successResponse('Order',Order::where('user_id',$request->user()->id)->get());
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
        $user = User::where('id',$request->user())->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $orders = OrderDetail::where('executer_id',null)->orderBy('created_at','desc')->with([
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

        $newToDo = new ToDoOrder([
            'executer_id' => $request->user()->id,
            'order_detail_id' => $request->order_id,
            'is_confirmed' => 0,
        ]);
        $newToDo->save();

        return $this->response->successResponse('ToDoOrder',$newToDo);
    }

    public function my_to_do_requests(Request $request, $status) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user())->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        if($status == null) {
            return $this->response->errorMessage('Error Status');
        }

        if($status == 'in_progress') {
            $status = 1;
            $toDo = ToDoOrder::where('executer_id',$request->user()->id)->where('is_confirmed', $status)->with([
                'orderDetails' => function ($query) {
                    $query->with('order','steps','service','hajPurpose','KfaraChoice','order.user');
                }
            ])->get();
        }

        if($status == 'pending') {
            $status = 0;
            $toDo = ToDoOrder::where('executer_id',$request->user()->id)->where('is_confirmed', $status)->with([
                'orderDetails'
            ])->get();
        }
        return $this->response->successResponse('ToDoOrder',$toDo);
    }

}
