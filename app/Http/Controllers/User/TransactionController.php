<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Transaction;
use App\Model\TourForm;
use App\Model\UserForm;
use App\Model\Basket;
use App\Model\About;
use App\Model\Service;
use App\Model\OffCode;
use App\Model\ServicePackage;
use App\Model\FormPrice;
use App\Model\ServiceFactor;
use App\Model\Network;
use App\Model\ServicePlusBuy;
use App\Model\ServicePackagePrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\Contact;

class TransactionController extends Controller {
    public function __construct() {
       $this->middleware(['auth','isAdmin']);
    }

    public function merchant_id()
    {
        return '4b5ff8a2-369a-4220-b8b2-39ccec62dd16';
    }

    public function backLink($id)
    {
        return url('/')."/user-transaction"."/".$id."/edit";
    }

    public function index($id) {
        $data = Transaction::findOrFail($id);
        $data->amount = number_format($data->amount);
        return view('user.report', compact('data'));
    }

    public function create() {
        $users      = User::where('reagent_id', auth()->user()->id )->count();
        $network    = Network::where('user_id',1)->where('status', 'active')->orderBy('sort')->get();
        $packages   = FormPrice::orderBy('sort')->get();

        $user_price = $packages->where('type','user')->first()->amount;
        $sms_price  = $packages->where('type','sms')->first()->amount;

        if( $packages->where('type','user')->first()->off_amount ) {
            $user_price = $packages->where('type','user')->first()->off_amount;
        }
        if( $packages->where('type','sms')->first()->off_amount ) {
            $user_price = $packages->where('type','sms')->first()->off_amount;
        }
        return view('user.transaction.create', compact('network','packages','users','user_price','sms_price'));
    }
    
    public function show($id)
    {
        $transaction    = Transaction::findOrFail($id);
        if ($transaction->status) {
            return redirect()->route('user.user-transaction-report', $transaction->id);
        }
        $user           = User::find( $transaction->user_id );
        $email          = $user->email ?? '';
        $mobile         = $user->mobile ?? '';

        $data = array("merchant_id" => $this->merchant_id(),
            "amount"        => $transaction->amount * 10,
            "callback_url"  => $this->backLink($transaction->id),
            "description"   => $transaction->type ?? '',
            "metadata"      => [ "email" => $email ,"mobile"=> $mobile ],
            );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);

        if ($err) {
            // dd("cURL Error #:" .$err);
            $transaction->description = $transaction->description." + Error associated with payment gateway";
            $transaction->save();
        } else {
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                }
            } else {
                // dd("Error Code:" .$result['errors']['code'] , "message: " .  $result['errors']['message']);
                $transaction->description = $transaction->description." + Error associated with payment gateway 2";
                $transaction->save();
            }
        }
    }

    public function edit($id)
    {
        // اگر تراکنش کنسل شده بود 
        if ($_GET['Status']=="NOK") {
            return redirect()->route('user.index');
        }
        $transaction    = Transaction::findOrFail($id);
        // اگر تراکنش تایید شده بود -> یعنی تکراری بود
        if ($transaction->status) {
            return redirect()->route('user.user-transaction-report', $transaction->id);
        }
        $Authority      = $_GET['Authority'];
        $data = array("merchant_id" => $this->merchant_id(), "authority" => $Authority, "amount" => $transaction->amount * 10);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        try {
            if ($result['data']['code'] == 100) {
                $transaction->status                    = $result['data']['code'];
                $transaction->card_number               = $result['data']['card_pan'];
                try {
                    $transaction->confirmtransactionnumber  = $result['data']['ref_id'];
                } catch (\Throwable $th) { }
                $transaction->tracing_code              = $result['data']['card_hash'];
                $transaction->bank_name                 = "zarinpal";
                $transaction->save();
                // فعال کردن تور خریداری شده
                if ($transaction->type=="buy_tour") {
                    $tours = TourForm::where('transaction_id', $transaction->id)->get();
                    foreach ($tours as $tour) {
                        $tour->cancel = 'active';
                        $tour->save();
                    }
                }
                // فعال کردن فرم خریداری شده
                elseif ($transaction->type=="buy_form") {
                    $form = UserForm::where('id', $transaction->factor_id)->first();
                    $form->pay_status = 'active';
                    $form->save();
                }
                // فعال کردن کارگاه خریداری شده
                elseif ($transaction->type=="package") {
                    $basket = Basket::where('id', $transaction->factor_id)->first();
                    $basket->status = 'active';
                    $basket->save();
                }

            } else {
                // dd("code: " . $result['errors']['code']." , message: " .  $result['errors']['message']);
                $transaction->description = $transaction->description." + Error confirming transaction";
                $transaction->save();
            }
        } catch (\Throwable $th) {
            // dd("catch: ".$th);
            $transaction->description = $transaction->description." + Error confirming transaction 2";
            $transaction->save();
        }
        return redirect()->route('user.user-transaction-report', $transaction->id);
    } 

}


//     public function factor() 
//     {
//         return $this->belongsTo('App\Model\ServiceFactor','factor_id');
//     }
//     public function user()
//     {
//         return $this->belongsTo('App\User','user_id');
//     }

//     public static function pay($type)
//     {
//         switch ($type){
//             case '1':
//                 return '<span class="badge bg-success ml-1">پرداخت موفق</span>';
//                 break;
//             case '0':
//                 return '<span class="badge bg-danger ml-1">پرداخت ناموفق</span>';
//                 break;
//             default:
//                 return '';
//                 break;
//         }
//     }
//     public static function replace($type)
//     {
//         return str_replace('A00000000000000000000000000','',$type);
//     }
// }