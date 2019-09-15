<?php


namespace App\Libraries;



class Mpesa{

    public function stk_push(){

        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer 6zz7wMf6ISXexppnjQNvtQJs3i3z')); //setting custom header


        $curl_post_data = array(
        //Fill in the request parameters with valid values
        'BusinessShortCode' => '759955',
        'Password' => 'NzU5OTU1NDY0YzI2Yjg0MTQ2ODI2MzA4OTFhMDAwOTIxZGJhODcxZWQ1YjMwMGRlMTM0MmUxOTdkMWZmMmQ0YjgwMTI0MjIwMTkwOTE0MTcxODAx',
        'Timestamp' => '20190914171801',
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => '1',
        'PartyA' => '254708003481',
        'PartyB' => '759955',
        'PhoneNumber' => '254708003481',
        'CallBackURL' => 'https://cc5cef50.ngrok.io/api/stk/callback',
        'AccountReference' => 'Daiwa Sasa',
        'TransactionDesc' => 'pay daiwa sasa ltd'
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        print_r($curl_response);

        // echo $curl_response;
            }
}
