<?php

namespace Modules\Doctor\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use JWTFactory;
use JWTAuth;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class APILoginController extends Controller
{

    public function __construct()
    {

       // $this->doctor = new Doctor();

    }

    public function login(Request $request)
    {
        $status = "success";
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = Doctor::getUser($request->email);
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //dd($user->is_active);

        if(($user->is_active)==1){
            $result=array('status'=>$status,'token'=>$token);
        }
        else{
            $status="Otp not validated.";
            $result=array('status'=>$status);
        }

        return response()->json($result);
    }




    public function getAuthUser(Request $request){
//dd('hi');
        $user = JWTAuth::toUser($request->token);

        return response()->json(['result' => $user]);
    }
}