<?php

namespace App\Listeners;

use App\Events\UserListed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\Sms;

// use Auth;

class HandleListedUser
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
     * @param  UserListed  $event
     * @return void
     */

    public function handle(UserListed $event)
    {
        //
        $id=mt_rand(000000,999999);
        $debtor_phone=$event->debtor->Mobile_no;
        $credentials=array(
            'msisdn'=>$debtor_phone,
            'destination'=>'DAIWA_SASA',
            'message'=>'hello'.$event->debtor->Fullnames.'You have been listed in Daiwa Sasa platform By'.auth()->user()->firstname.'using the No.'.auth()->user()->mobile_no,
            'sms_id'=>$id
          );
        $sms=new Sms;
        $sms->sendMsg($credentials);
    }
}
