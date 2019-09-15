<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Debtor;
use App\payment;
use App\ProcessingPayment;
use App\Libraries\Sms;
use App\Events\UserListed;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Validator;
use Auth;
use App\Libraries\Mpesa;

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
        // $response = STK::push( 1, 254729636948 , 'DAIWA SASA LTD', 'Test Payment','production');
        $mp=new Mpesa;
        $mp->stk_push();
        // $res='listingggggggggg!';
        // echo $res;
        // return response()->json($response);
    }
    public function mpesa_res(Request $request){
       $array= json_decode($request,true);
                print_r($array);
       return response($array);

    }

    // public function delist_user(){

    // }
}
