<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResponse;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
class PaymentController extends Controller
{
    public $response;

    public function __construct()
    {
        $this->response = new ApplicationResponse();
    }
    public function payWithWallet($request) {
        if( ! $request->user) {
            $this->response->unAuthroizeResponse();
        }

        if(! $request->order) {
            $this->response->ErrorResponse("No Order Found");
        }
        $price = $request->order->price;
        $user = $request->user;
        $order = $request->order;
        $currency_id = $request->order->currency_id;
        $defaultCurrencyId = 1; // change to default currency from settings
        $adminWalletId =1;
        if($currency_id != $defaultCurrencyId) {
            $price = round($price * $user->currency->convert_value,2);
        }

        if($price >= $user->wallet->amount) {
            $newTransaction = new WalletTransaction([
                'wallet_id' => $adminWalletId,
                'amount' => $price,
                'currency_id' => $currency_id,
                'is_transfered' => 1,
                'transfer_from' => $user->id,
                'transfer_to' => 1,
                'reason' => 'دفع قيمة طلب من المحفظة',
                'refer_to_order_detail' => $order->id,
            ]);
            $newTransaction->save();
            $adminWallet = Wallet::where('id',1)->firt();
            $adminWallet->amount += $price;
            $adminWallet->save();

            $userWallet = Wallet::where('id',$user->id)->first();
            $userWallet->amount -= $price;
            $userWallet->save();

            $orderDB = Order::where('id',$order->id)->select('id','payment_status_id')->first();
            $orderDB->payment_status_id = 8;
            return true;
        } else {
            return false;
        }
    }

    public function payWithPrize($request) {
        if( ! $request->user) {
            $this->response->unAuthroizeResponse();
        }

        if(! $request->order) {
            $this->response->ErrorResponse("No Order Found");
        }
    }
}
