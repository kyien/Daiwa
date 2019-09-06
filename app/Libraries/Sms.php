<?php

namespace App\Libraries;
// use
use \GuzzleHttp\Client;

use \GuzzleHttp\Exception\RequestException;

use \GuzzleHttp\Psr7\Request;

class Sms {


 //get token
    public function get_auth_token(){

        $myobj=array(
            'grant_type'=>'password',
            'username'=>'daiwa',
            'password'=>'daiwa@2019',
            'client_id'=>'140',
            'client_secret'=>'Rp4vBC5JTNssBqRE'
        );

        $auth_obj=json_encode($myobj);

        // $headers =

        $client=new \GuzzleHttp\Client([
            'headers'=>[
            'content-type' => 'application/json'
            ]
            ]);

        $res=$client->request('POST','https://smsonfon.onfonmedia.co.ke/oauth2/token',
        [
            'body' =>$auth_obj
        ]);

        // return $auth_obj;
             echo $res->getBody();
    }

    public function sendMsg($credentials){
        // echo $this->get_auth_token();
        $body=array();
        // $credentials=array(
        //   'msisdn'=>'254708003481',
        //   'destination'=>'DAIWA_SASA',
        //   'message'=>'HELLO MISTER',
        //   'sms_id'=>'2342'
        // );

         array_push($body,$credentials);
         $json=json_encode($body);

          //  $token=$this->get_auth_token();
          //  $all= 'Bearer '.$token;

        $client=new \GuzzleHttp\Client([
            'headers'=>[
            'Authorization'=>'Bearer 32925a3aa71a3a6985f8199ffc5dd66e7ace5094',
            'content-type' => 'application/json'
            ]
            ]);

        $res=$client->request('POST','https://smsonfon.onfonmedia.co.ke/v1/sendsms/sms',
        [
            'body' =>$json
        ]);

       echo $res->getBody();

        // echo $json;
    }
}
