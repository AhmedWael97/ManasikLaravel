<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResponse;
use App\Models\Currency;
use App\Models\OrderDetail;
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
            $orderDB->payment_status_id = 11;
            $orderDB->save();

            $orderDetails = OrderDetail::where('order_id',$order->id)->get();
            foreach($orderDetails as $orderDetail) {
                $orderDetail->is_confirmed = 1;
                $orderDetail->save();
            }
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

    public function MyBalanceHistory(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $wallet = Wallet::where('user_id',$request->user()->id)->select('user_id','currency_id','amount')->with('currency')->first();
        if($wallet == null) {
            return $this->response->ErrorResponse('No wallet for current user');
        }

        $totalInActions = WalletTransaction::where(['wallet_id'=>$wallet->id, 'transfer_to'=>$request->user()->id])->with(['from','to','currency'])->get();
        $totalOutActions = WalletTransaction::where(['wallet_id'=>$wallet->id,'transfer_from'=>$request->user()->id])->with(['from','to','currency'])->get();

        $walletTransactions = [
            'wallet' => $wallet,
            'Income' => $totalInActions,
            'Paid' => $totalOutActions,
        ];

        return $this->response->successResponse('Wallet',$walletTransactions);
    }
}
