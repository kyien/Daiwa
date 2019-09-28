<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Debtor;
use App\Payment;
use App\ProcessingPayment;
use App\Libraries\Sms;
use App\Events\UserListed;
use \Safaricom\Mpesa\Mpesa;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Validator;
use Auth;
// use App\Libraries\Mpesa;

class DebtorsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['assign.guard:tokenuser','verifiedphone']);
    }

    public function add_debtor(Request $request){

            //validation
        $rules = [
            'Fullnames' => 'required|string|max:50',
            'nickname_company' => 'required|string|max:50',
            'Mobile_no' => 'required|numeric|digits_between:10,12',
            'Amount_owed'=>'required|numeric',
            'debt_age'=>'required|numeric',
            'type_of_debt'=>'required|string',
            'listing_option'=>'required'

    
    
          ]; // creating an array of rules
          $validator = Validator::make($request->all(),  $rules); // checking the request agaainst the rules
    
          if($validator->fails()){
            return response()->json($validator->errors(),400);
          }


         // switch listing options

          switch($request -> input('listing_option')){
                case 1:
                $response = STK::push( 20, 254708003481 , 'Daiwa', 'Test Payment');
                case 2:
                $response = STK::push( 50, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
                case 3:
                $response = STK::push( 100, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
                case 4:
                $response = STK::push( 150, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
                case 5:
                $response = STK::push( 200, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
            default: 
            $reponse = 'invalid option';
            
            }

             $code='DWS_'.mt_rand(000000,999999);

        $debtor=Debtor::create([
           'Fullnames'=> $request -> input('Fullnames'),
           'nickname_company'=> $request -> input('nickname_company'),
           'Amount_owed'=>$request -> input('Amount_owed'),
           'Mobile_no'=>$request ->input('Mobile_no'),
           'type_of_debt'=>$request -> input('type_of_debt'),
           'debt_age'=>$request -> input('debt_age'),
           'users_id'=>Auth::guard('tokenuser')->user()->id,
           'listing_option'=> $request -> input('listing_option'),
           'code'=>$code
        ]);

        if($debtor){
            // event(new UserListed($debtor));
            echo "success";
        }
      else{
          echo "failure!";
      }

    }

    public function mpesa_test(){
            // $user=Auth::guard('tokenuser')->user()->mobile_no;
            // echo $user;
         
        $response = STK::push( 1,Auth::guard('tokenuser')->user()->mobile_no,'DAIWA SASA LTD', 'Service Payment','production');
        
            sleep(20);

            $m_ID=$response->MerchantRequestID;

            $payment=Payment::where('MerchantRequestID',$m_ID)->first();

            if($payment){

                echo "paid";
            }

            else{
                echo "not paid";
            }
       
        // return response()->json($response->MerchantRequestID);
    }
    public function mpesa_res(){
        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $callbackData = json_decode($mpesa->getDataFromCallback(),false);
        echo $callbackData;


        // if ($callbackData->Body->stkCallback->ResultCode === 0) {
        //     // Handle success (e.g. Update the transaction with an equal MerchantRequestID/CheckoutRequestID to "complete" status)
        //     echo 'seccessssssss!';
        // }
        $mpesa->finishTransaction();
        
             }

    // public function delist_user(){

    // }
}
