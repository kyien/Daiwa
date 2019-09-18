<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Debtor;
use App\payment;
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
    public function add_debtor(Request $request){

            //validation
        $rules = [
            'Fullnames' => 'required|max:20',
    
          ]; // creating an array of rules
          $validator = Validator::make($request->all(),  $rules); // checking the request agaainst the rules
    
          if($validator->fails()){
            return response()->json($validator->errors(),400);
          }


          //switch listing options

        //   switch($request -> input('listing_option')){
        //         case 'A':
        //         $response = STK::push( 20, 254708003481 , 'Daiwa', 'Test Payment');
        //         case 'B':
        //         $response = STK::push( 50, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
        //         case 'C':
        //         $response = STK::push( 100, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
        //         case 'D':
        //         $response = STK::push( 150, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
        //         case 'E':
        //         $response = STK::push( 200, Auth::user()-> mobile_no , 'Daiwa', 'Test Payment');
        //     default: 
        //     $reponse = 'invalid option';
            
        //     }

        //     echo $response;

        $debtor=Debtor::create([
           'Fullnames'=> $request -> input('Fullnames'),
           'nickname_company'=> $request -> input('nickname_company'),
           'Amount_owed'=>$request -> input('Amount_owed'),
           'Mobile_no'=>$request ->input('Mobile_no'),
           'type_of_debt'=>$request -> input('type_of_debt'),
           'debt_age'=>$request -> input('debt_age'),
           'users_id'=>$request->input('user'),
           'listing_option'=> $request -> input('listing_option'),
           'code'=>rand(1,10000)
        ]);

        if($debtor){
            event(new UserListed($debtor));
        }
    

    }

    public function mpesa_test(){

        $mpesa=new Mpesa();
        // $response = STK::push( 1, 254729636948 , 'DAIWA SASA LTD', 'Test Payment','production');
        $stkPushSimulation=$mpesa->STKPushSimulation(
            759955,
           '464c26b8414682630891a000921dba871ed5b300de1342e197d1ff2d4b801242',
           'CustomerPayBillOnline',
            1, 
            254729636948, 
            759955, 
            254729636948, 
           'https://a5385ea2.ngrok.io/api/callback/mpesa', 
           'Daiwa sasa',
           'pay daiwa sasa ltd',
           'happy life'
              );


    echo  $stkPushSimulation;
        // $mp=new Mpesa;
        // $mp->stk_push();
        // $res='listingggggggggg!';
        // echo $res;
        // return response()->json($response);
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
