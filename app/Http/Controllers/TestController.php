<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Sms;
class TestController extends Controller
{
    //


    protected function sms_creds(){
      $credentials=array(
        'msisdn'=>'254708003481',
        'destination'=>'DAIWA_SASA',
        'message'=>'still testing',
        'sms_id'=>'2154'
      );

      return $credentials;
    }

    protected function sms_send(){

      $sms=new Sms();

      $res=$sms->sendMsg($this->sms_creds());

      echo $res;
    }
}
