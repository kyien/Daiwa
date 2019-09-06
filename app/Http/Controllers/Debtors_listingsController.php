<?php

namespace App\Http\Controllers;
// namespace App\Libraries;

use Illuminate\Http\Request;
use App\Debtors_listings;
use App\payment;
use App\ProcessingPayment;
use Validator;
use App\Http\Resources\Debtors_listings as Debtors_listingsResource; // modifies what you see on the front end
use App\Libraries\Sms;

use SmoDav\Mpesa\Laravel\Facades\STK;

class Debtors_listingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $Debtors_listings = Debtors_listings::all();
    return response()->json($Debtors_listings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('debtors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
        'Fullnames' => 'required|max:20',

      ]; // creating an array of rules
      $validator = Validator::make($request->all(),  $rules); // checking the request agaainst the rules

      if($validator->fails()){
        return response()->json($validator->errors(),400);
      }



     // $response = STK::validate('ws_CO_16022018125');

    // 'Fullnames',
    // 'nickname_company',
    // 'Amount_owed',
    // 'Mobile_no',
    // 'type_of_debt',
    // 'debt_age',
    // 'users_id',
    // 'listing_option',
    // 'code',

    // create debtor list
    // input information
    $Debtors_listings = new Debtors_listings;

    $Debtors_listings-> Fullnames = $request -> input('Fullnames');
    $Debtors_listings-> nickname_company = $request -> input('nickname_company');
    $Debtors_listings-> Amount_owed = $request -> input('Amount_owed');
    $Debtors_listings-> Mobile_no = $request -> input('Mobile_no');
    $Debtors_listings-> type_of_debt = $request -> input('type_of_debt');
    $Debtors_listings-> debt_age = $request -> input('debt_age');
    $Debtors_listings-> users_id = rand(10,100);
    $Debtors_listings-> listing_option = $request -> input('listing_option');
    $Debtors_listings-> code = rand(1,10000); // rand(min,max)


    $response = STK::push( $Debtors_listings-> listing_option, $Debtors_listings-> Mobile_no , 'Daiwa', 'Test Payment');
  //   return response()->json($response);

  //  $result = json_encode($response, true);


  //  $response->get('BillRefNumber');

    $processing_payment = new ProcessingPayment;
    $processing_payment-> MerchantRequestID = $response->MerchantRequestID;
    $processing_payment-> CheckoutRequestID = $response->CheckoutRequestID;
    $processing_payment-> ResultCode = $response->ResponseCode;
    $processing_payment-> ResultDesc = $response->ResponseDescription;
    $processing_payment-> Mobile_No = $Debtors_listings-> Mobile_no;
    $processing_payment-> Amount_Paid = $Debtors_listings-> listing_option;

    if($processing_payment-> ResultCode==0){


      $msisdn = $Debtors_listings-> Mobile_no;
      $message = 'Hello '.$Debtors_listings-> Fullnames.' alias '.$Debtors_listings-> nickname_company.' you have been listed on daiwa sasa by $User for unpaid debt of Ksh.'.$Debtors_listings-> Amount_owed.'.This makes your debt status public. Pay $User, $Number to be delisted. You can also list those who owe you ';
      $sms_id = rand(0000,9999);
      $resp = $this->send_sms($msisdn,$message,$sms_id);




      $processing_payment->save();
      $Debtors_listings-> save();

      // return $resp;
      // send sms after saving.
    }
    else {
      return 'You have not paid, please try again';
    }
    // return response()->json($response);

    // if($processing_payment-> ResultCode==0){
    //   $processing_payment->save();
    //   $Debtors_listings-> save();
    // }
    // else {
    //   return 'Your payment was not successful please retry';
    // }






  //  return response()->json($response);
  // User::find($id)->post->content;  // getting information from the db check tutorial C:\Users\admin\Downloads\[FreeTutorials.Eu] Udemy - PHP with Laravel for beginners - Become a Master in Laravel\11. Laravel Fundamentals - Database - Eloquent Relationships tut2
    // 'MerchantRequestID',
    // 'CheckoutRequestID',
    // 'ResultCode',
    // 'ResultDesc',


// havent specified the response received
    // $payment->MerchantRequestID = $response
    // $payment->CheckoutRequestID = $response
    // $payment->ResultCode = $response
    // $payment->ResultDesc = $response



    // $payment-> save();


  //  $Debtors_listings-> save();     // save to database


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */







  public function show($id)
    {
      $debtor = Debtors_listings::find($id);
      if(is_null($debtor)){
        return response()->json(null,404);
      }
        $response = new Debtors_listingsResource(Debtors_listings::find($id), 200); // debtorslisting resource modifies the data being outputted to what you want it to show
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
    //{
    //            $id->delete();
      //          return response()->json(null, 204);

  //  }
    public function destroy(Request $request)
    {
          //      $Debtors_listings->delete();
          //      return response()->json(null, 204);
          $Debtors_listings =Debtors_listings::where('Mobile_no', 254708266353);
          $Debtors_listings->delete();
    }


    public function register()
{
    $confirmation = 'https://e8c0dc93.ngrok.io/mpesa/confirm';
    $validation = 'https://e8c0dc93.ngrok.io/mpesa/validate';
    $response = Registrar::register(600000)
        ->onConfirmation($confirmation)
        ->onValidation($validation)
        ->submit();
    return response()->json($response);
}

public function confirmTransaction(Request $request)
{
  $payment = new payment;
  $payment-> MerchantRequestID = $request->MerchantRequestID;
  $payment-> CheckoutRequestID = $request->CheckoutRequestID;
  $payment-> ResultCode = $request->ResultCode;
  $payment-> ResultDesc = $request->ResultDesc;

  // var_dump(json_encode($payment));
  // exit();
//  $payment-> Mobile_No = $Debtors_listings-> Mobile_no;
//  $payment-> Amount_Paid = $Debtors_listings-> listing_option;
  $payment->save();




  // return response()->json($request, 200);
//     if ($transaction = Transaction::find($request->get('ThirdPartyTransID'))) {
//         $transaction->update(['status' => Transaction::STATUS_COMPLETE]);
//         return $this->successfulResponse($transaction);
//     }
//     if (!$invoice = $this->getInvoice($request->get('BillRefNumber', 0))) {
//         return $this->invalidInvoiceNumberResponse();
//     }
//     $transaction = $this->createTransaction($request, $invoice, Transaction::STATUS_COMPLETE);
//     return $this->successfulResponse($transaction);
}

    public function send_sms( $msisdn,$message,$sms_id){

        $mySms=array(
            'msisdn'=>$msisdn,
            'destination'=>'DAIWA_SASA',
            'message'=>$message,
            'sms_id'=> $sms_id
        );
        $sms=new Sms;
        $res=$sms->sendMsg($mySms);
    }


}
