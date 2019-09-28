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

//JWT Routes here for token based Authentication

// Route::group([

//   'middleware' => 'api',
//   // 'namespace' => 'App\Http\Controllers',
//   'prefix' => 'auth'

// ], function () {

  Route::post('login', 'AuthController@login');
  Route::post('register', 'AuthController@register');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('verify', 'AuthController@verify');
  Route::get('me', 'AuthController@me');

// });

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
Route::post('/insert','DebtorsController@add_debtor');

Route::any('/stk/push', 'DebtorsController@mpesa_test');
// Route::any('/mpesa/callback', 'DebtorsController@mpesa_res');
Route::any('/stk/callback', 'DebtorsController@mpesa_res');
// Route::any('/stk/callback', function(){
//   $data=file_get_contents('php://input');

//   echo $data;
// });
