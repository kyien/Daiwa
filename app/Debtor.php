<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Debtor extends Model
{
  protected $table='debtors_listings';

  protected $fillable = [
   'Fullnames',
   'nickname_company',
   'Amount_owed',
   'Mobile_no',
   'type_of_debt',
   'debt_age',
   'users_id',
   'listing_option',
   'code',
];
// public function users(){
//
//   return $this->hasMany(App\User);
// }
}
