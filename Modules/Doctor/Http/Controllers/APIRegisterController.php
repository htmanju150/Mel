<?php

namespace Modules\Doctor\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Mail\WelcomeMail;
use App\Models\DocProfile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use JWTAuthException;

use App\Notifications\WelcomeNotification;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;

class APIRegisterController extends Controller
{

    public function registerUser(Request $request) {
        $status = "success";
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $check_email = new Doctor();
            $email_exist = $check_email->email_ph_details($request->email,$request->phone);
           // dd($email_exist);
            if (empty($email_exist)) {

                $data['salutation'] = 'Mr.';
                $user = Doctor::createUser( $data['email'], $data['password'],
                    $data['first_name'], $data['last_name'],
                    $data['salutation'], $data['phone']);
                $users = Doctor::first();
                // Send Email & SMS

                $emailJob = (new SendEmailJob($user))->delay(Carbon::now()->addSeconds(3));
                $smsJob = (new SendSmsJob($user))->delay(Carbon::now()->addSeconds(3));
                dispatch($emailJob);dispatch($smsJob);

                return response()->json(['status'=>$status]);
            }
            else{
                $status = "Error creating user - email or phone already exists";
                return response()->json(['status'=>$status]);
            }

        }

    }


    public function validateOtps(Request $request) {
        $status = "success";
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
            'custom_url' => 'required',
            'email_otp' => 'required|integer|min:10000|max:99999',
            'sms_otp' => 'required|integer|min:10000|max:99999',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = Doctor::getUser($data['email']);
            //dd($user);
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            if($user != null) {

                if($user->phone_token == $data['sms_otp'] && $user->email_token == $data['email_otp']) {
                    Auth::loginUsingId($user->id, true);
                    Doctor::makeUserLive($user);
                    if((DocProfile::getDoctorProfileId($user->id)!=null) ){
                        $status = "Custom Url already set for the user!";
                        return response()->json(array("status"=>$status));
                    }
                    elseif(DocProfile::getCustomUrl($data['custom_url'])!=null){
                        $status = "Custom Url already exist!";
                        return response()->json(array("status"=>$status));
                    }
                    else{
                        DocProfile::createDocProfile($user,$data['custom_url']);
                    }

                    $result=array('status'=>$status,'token'=>$token);

                } else {
                    $status = "OTP not valid!";
                    $result=array('status'=>$status);
                }
            } else {
                $status = "Unknown error!";
                $result=array('status'=>$status);
            }

            return response()->json($result);




        }

    }


  public function forgotPassword(Request $request) {
      $status = "success";
      $data = $request->all();
      $validator = Validator::make($data, [
          'phone' => 'required',
          'email' => 'required|string|email|max:255',
      ]);
      if ($validator->fails()) {
          $status = $validator->errors();
          return response()->json(['status'=>$status]);
      } else {
          $user = Doctor::getUser($data['email']);
          Doctor::updateDocOtp($user);
          $emailJob = (new SendEmailJob($user))->delay(Carbon::now()->addSeconds(3));
          $smsJob = (new SendSmsJob($user))->delay(Carbon::now()->addSeconds(3));
          dispatch($emailJob);dispatch($smsJob);

          return response()->json(["status"=>"success","result"=>array("email"=>$request->email,"phone"=>$request->phone)]);


      }

  }


    public function changePassword(Request $request) {
        $status = "success";
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'email_otp' => 'required|integer|min:10000|max:99999',
            'sms_otp' => 'required|integer|min:10000|max:99999',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = Doctor::getUser($data['email']);
            //dd($user);

            if($user != null) {

                if($user->phone_token == $data['sms_otp'] && $user->email_token == $data['email_otp']) {
                    Auth::loginUsingId($user->id, true);
                    Doctor::updateDocPwd($user,$data['password']);

                    $result=array('status'=>$status);

                }

                 else {
                    $status = "OTP not valid!";
                    $result=array('status'=>$status);
                }
            } else {
                $status = "User not found!";
                $result=array('status'=>$status);
            }

        }


            return response()->json($result);


        }










    public function getTestMail(Request $request) {
        //dd('hi');
        $user = new Doctor();
        $user->notify(new WelcomeNotification());
        return "Test Sms Sent";
    }
}