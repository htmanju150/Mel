<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\User;
use Illuminate\Http\Request;
use App\Doctor;
use Illuminate\Support\Facades\Mail;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use JWTAuthException;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        //dd('hi');
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:doctors',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        Doctor::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user = Doctor::first();
        //dd($user);
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }

    public function getTestMail(Request $request) {
        //dd('hi');
        Mail::to("maunch150@gmail.com")->send(new WelcomeMail());
        return "Test Email Sent";
    }
}