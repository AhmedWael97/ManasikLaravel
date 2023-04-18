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
            $totalPrice = 0;
            $totalPoints = 0;
            $newOrder = new Order([
                'user_id' => $request->user()->id,
            ]);
            $paymentType = PaymentType::find($request->payment_type_id)->select('id')->first();
            if($paymentType != null) {
                $newOrder->payment_type_id = $paymentType->id;
            }
            $service = Service::find($request->main_service_id)->select('id','price','earning_points')->first();
            if($service != null) {
                $newOrder->main_service_id = $request->main_service_id;
                $totalPrice += $service->price;
                $totalPoints += $service->earning_points;
            }
            $newOrder->payment_status_id = 1;
            $newOrder->order_code = rand(99999,999999);
            $newOrder->order_status_id = 1;
            $newOrder->currency_id = $request->user()->wallet->currency_id;
            $newOrder->is_from_wallet = $request->has('is_from_wallet') ? $request->is_from_wallet : 0;
            $newOrder->save();

            if($request->has('order_details') && count($request->order_details) >= 1) {
                foreach($request->order_details as $order_detail) {
                    $newOrderDetails = new OrderDetail([
                        'order_id' => $newOrder->id,
                    ]);
                    $service = Service::find($order_detail->service_id)->select('id','price','earning_points')->first();
                    if($service != null) {
                        $newOrderDetails->service_id = $order_detail->service_id;
                        $newOrderDetails->price = $service->price;
                        $totalPrice += $service->price;
                        $totalPoints += $service->earning_points;
                    }
                    $kfara = KfaratChoice::find($order_detail->no_of_kfara)->select('id')->first();
                    if($kfara != null) {
                        $newOrderDetails->kfarat_choice_id = $kfara->id;
                    }

                    $hajPurpose = HajPurpose::find($order_detail->purpose_hag_id)->select('id')->first();
                    if($hajPurpose != null) {
                        $newOrderDetails->purpose_hag_id = $hajPurpose->id;
                    }
                    $newOrderDetails->required_date = $order_detail->required_date;
                    $newOrderDetails->currency_id = $newOrder->currency_id;
                    $newOrderDetails->save();
                }
                $newOrder->price = $totalPrice;
                $newOrder->save();
            }

            return $this->successResponse('Order',$newOrder);

        } catch (Exception $e) {
            return $this->ErrorResponse($e->getMessage());
        }
    }
}
