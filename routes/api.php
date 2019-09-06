<?php

use Illuminate\Http\Request;
use App\Debtors_listings;
use App\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('/findwhere/{Mobile_no}',function($Mobile_no){
//  $Mobile_no = $Mobile_no->input('Mobile_no');
  $Debtors_listings =Debtors_listings::where('Mobile_no', $Mobile_no)->orderBy('Mobile_no','desc')->take(10)->get();
  return  $Debtors_listings;


});

Route::get('/delete/{Mobile_no}',function($Mobile_no){
//  $Mobile_no = $Mobile_no->input('Mobile_no');
  $Debtors_listings =Debtors_listings::where('Mobile_no', $Mobile_no);
  $Debtors_listings->delete();


});

Route::any('/sendsms','TestController@sms_send');
Route::resource('/insert','Debtors_listingsController');

Route::any('/mpesa/confirm', 'Debtors_listingsController@confirmTransaction');
