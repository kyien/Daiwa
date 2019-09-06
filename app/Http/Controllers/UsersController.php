<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function store(Request $request){
      $request->session()->put(['name',$request->input('name')]);
      $request->session()->get('name');



      $user = new User; // instantiate
      $user->name=$request->input('name');
      $user->email=$request->input('email');
      $user->password=$request->input('password');
      $user->mobile_no=$request->input('mobile_no');

    }
}
