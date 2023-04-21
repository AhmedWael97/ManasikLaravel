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

            $paymentType = PaymentType::find($request->paymentType)->select('id')->first();
            $isWallet = $request->isWallet;
            if($paymentType != null) {
                $payment_type_id = $paymentType->id;
            } else {
                return $this->response->ErrorResponse("Invalid Payment Type");
            }
            $newOrder = new Order();



            return $this->successResponse('Order',$newOrder);

        } catch (Exception $e) {
            return $this->ErrorResponse($e->getMessage());
        }
    }
}
