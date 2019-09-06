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
             return $res->getBody();
    }

    public function sendMsg($mySms){
        // echo $this->get_auth_token();
        $body=array();


         array_push($body,$mySms);
         $json=json_encode($body);

        //    $token=$this->get_auth_token();
        //    $all= 'Bearer '.$token;

        $client=new \GuzzleHttp\Client([
            'headers'=>[
            'Authorization'=>'Bearer 86ce12ffe89faf73b8d502e6379351cdb8f0ac43', //'Bearer e9db6169b1f5dfe9d370a1c3579ebddc446092b'
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
