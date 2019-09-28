<?php

namespace App\Libraries;
// use
use \GuzzleHttp\Client;

use \GuzzleHttp\Exception\RequestException;

use \GuzzleHttp\Psr7\Request;
use App\SmsListing;

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
             return $res->getBody();
    }

    public function sendMsg($credentials){
        // echo $this->get_auth_token();
        $body=array();
     
         array_push($body,$credentials);
         $json=json_encode($body);

           $tokenbody=json_decode($this->get_auth_token(),true);
        //    $luck=$token["access_token"];

           $token= 'Bearer '.$tokenbody["access_token"];

        $client=new \GuzzleHttp\Client([
            'headers'=>[
            'Authorization'=> $token,
            'content-type' => 'application/json'
            ]
            ]);

        $res=$client->request('POST','https://smsonfon.onfonmedia.co.ke/v1/sendsms/sms',
        [
            'body' =>$json
        ]);

    //    echo $res->getBody();

       $feedback=json_decode($res->getBody());

       if($feedback[0]->status == 100){
            $sms_rec=SmsListing::create([
                'recipient'=>$credentials['msisdn'],
                'message' =>$credentials['message'],
                'sms_id'=>$credentials['sms_id']
            ]);
            
            // return response()->json([
            //                     'res'=>$sms_rec
            //                 ],200);
       }

    //    return response()->json([
    //                 'res'=>'unable to store sms'
    //    ],417);
    }
}
