<?php
namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Address;
use App\FailedTranscations;
use App\Invoice;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;

class PaytmController extends Controller
{
    public function payProcess(Request $request)
    {
        $cart_table = Auth::user()->cart;
        $total = 0;

        require_once 'price.php';

        $total = getcarttotal();
        
        $total = sprintf("%.2f",$total * $conversion_rate);
        
        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        $orderID = uniqid();
        $adrid = Session::get('address');
        $address = Address::findOrFail($adrid);
        $inv_cus = Invoice::first();
        $amount = round(Crypt::decrypt($request->amount), 2);
        $payment = PaytmWallet::with('receive');

        $payment->prepare([
            'order' => $orderID,
            'user' => Auth::user()->id,
            'mobile_number' => $address->phone,
            'email' => $address->email,
            'amount' => $amount,
            'callback_url' => url('/paidviapaytmsuccess'),
        ]);

        return $payment->receive();
    }

    public function paymentCallback()
    {

        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        
        if ($transaction->isSuccessful()) {
            
            $txn_id = $response['TXNID'];

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Paytm',session()->get('order_id'),$payment_status);
           

        } elseif ($transaction->isFailed()) {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));

        } elseif ($transaction->isOpen()) {
            //Transaction Open/Processing

        } else {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));
        }

    }
}
