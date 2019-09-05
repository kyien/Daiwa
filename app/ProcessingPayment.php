<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessingPayment extends Model
{
  protected $fillable = [

  'MerchantRequestID',
  'CheckoutRequestID',
  'ResultCode',
  'ResultDesc',
  'Mobile_No',
  'Amount_Paid',

];

}
