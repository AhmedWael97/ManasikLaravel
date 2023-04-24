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
                            'purpose_hag_id' => $minService['HajPurpose'],
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

        $orderDetails = OrderDetail::where('order_id',$order->id)->with('service')->get();

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
}
