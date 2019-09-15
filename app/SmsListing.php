<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsListing extends Model
{
    //
    protected $fillable=['recipient','message','sms_id'];
}
