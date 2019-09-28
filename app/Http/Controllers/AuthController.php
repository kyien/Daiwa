<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\TokenUser;
use App\Events\UserRegistered;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public $user;

    public function __construct()
    {
        $this->middleware(['assign.guard:tokenuser','verifiedphone'], ['except' => ['login','register','verify']]);
    }

  
    public function login(Request $request)
    {
        $credentials = $request->only('mobile_no');
        $user=TokenUser::where('mobile_no',$credentials)->first();

        // if ($token = $this->guard()->attempt($credentials)) {


        if (!$token = JWTAuth::fromUser($user)) {

            return response()->json(['error' => 'Unauthorized'], 401);

        }

        return $this->respondWithToken($token,$user);

    }

    public function verify(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'code'=> 'required'
        // ]);
        $user=TokenUser::where('mobile_no',$request->get('mobile_no'))->first();

        $code=$user->verification_code;

        if($code != $request->get('code')) {
            $user->delete();
            return response()->json(['message' => 'invalid verification code'], 417);
        } 
        else{
        // $user
       $user->markPhoneAsVerified();

        return response()->json(['message' => 'phone verified','user'=>$user], 200);

     }
    }

    public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'mobile_no' => 'required|numeric|digits_between:10,12|unique:token_users',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(),400);
            }

            // $rand=mt_rand(0000,9999);

            // echo $rand;

            $user = TokenUser::create([
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'location' => $request->get('location'),
                'mobile_no'=>$request->get('mobile_no'),
                'verification_code' =>mt_rand(0000,9999)

            ]);

            event(new UserRegistered($user));
            // $token = JWTAuth::fromUser($user);
                if($user){
                    $token = JWTAuth::fromUser($user);
                    return response()->json(['message'=>'successful registration','user'=>$user,'token'=>$token],201);
                    // return response()->json(['message'=>'successful registration','user'=>$user],201);
                }
                else{
                    return response()->json(['message'=>'failed registration'],417);

                }
        }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out'],200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

  
    protected function respondWithToken($token,$user)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ],200);
    }

    public function guard()
    {
        return Auth::guard('tokenuser');
    }
}