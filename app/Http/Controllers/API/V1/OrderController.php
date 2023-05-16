<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\HajPurpose;
use App\Models\KfaratChoice;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentType;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationResponse;
class OrderController extends Controller
{
    public $response;

    public function __construct()
    {
        $this->response = new ApplicationResponse();
    }
    public function store(Request $request) {
        try {
            if(! $request->user()) {
                return $this->response->unAuthroizeResponse();
            }

            $paymentType = PaymentType::find($request->paymentType)->select('id')->first();
            $isWallet = $request->isWallet;
            if($paymentType != null) {
                $payment_type_id = $paymentType->id;
            } else {
                return $this->response->ErrorResponse("Invalid Payment Type");
            }

            if($request->has('cart') && count($request->cart) >= 1) {
                foreach($request->cart as $requestOrder) {

                    if( ! $requestOrder->services && ! count($requestOrder->services) >= 1 ) {
                        return $this->response->ErrorResponse("Invalid Child Services");
                    }

                    $newOrder = new Order([
                        'user_id' => $request->user()->id,
                        'main_service_id' => $requestOrder->mainServiceId,
                        'payment_type_id' => $paymentType->id,
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
                    foreach($requestOrder->services as $minService) {
                        $service = Service::where('id',$minService->serviceId)->first();
                        $price += $service->price;
                        $newOrderDetails = new OrderDetail([
                            'order_id' => $newOrder->id,
                            'service_id' => $service->id,
                            'order_status_id' => $newOrder->order_status_id,
                            'full_name' => $minService->name,
                            'currency_id' => $newOrder->currency_id,
                            'price' => $service->price,
                            'executer_price' => $service->executer_price,
                            'no_of_kfara' => $minService->KfaraCount,
                            'kfarat_choice_id' => $minService->KfaraChoiceId,
                        ]);
                        $newOrderDetails->save();
                    }

                    $newOrder->price = $price;
                    $newOrder->save();

                    return $this->response->successResponse('Order',$newOrder);
                }
            } else {
                return $this->response->ErrorResponse('No Services Selected');
            }



            return $this->successResponse('Order',$newOrder);

        } catch (Exception $e) {
            return $this->ErrorResponse($e->getMessage());
        }
    }
}
