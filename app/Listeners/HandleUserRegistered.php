<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Sms;

class HandleUserRegistered 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //
        $id=mt_rand(000000,999999);
        $user_phone=$event->user->mobile_no;
        $credentials=array(
            'msisdn'=>$user_phone,
            'destination'=>'DAIWA_SASA',
            'message'=>'Your Verification code'.$event->user->verification_code,
            'sms_id'=>$id
          );
        $sms=new Sms;
        $sms->sendMsg($credentials);
    }
}
