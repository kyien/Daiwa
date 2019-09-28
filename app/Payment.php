<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model

{

  protected $table='payments';

  protected $fillable = [

  'MerchantRequestID',
  'CheckoutRequestID',
  'ResultCode',
  'ResultDesc',
  'Mobile_No',
  'Amount_Paid',
  'Receipt_No',
  'Transaction_Date'
];

}
