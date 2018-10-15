<?php

namespace Modules\Doctor\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Mail\WelcomeMail;
use App\Models\DocAccreditation;
use App\Models\DocExperience;
use App\Models\DocGovt;
use App\Models\DocProfile;
use App\Models\DocQualification;
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

class DoctorProfile extends Controller
{







    public function checkCustomUrl(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
            'custom_url' => 'required',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $url = DocProfile::getCustomUrl($data['custom_url']);

            if(!empty($url)){

                $status="Url already exist.";
            }
            else{
                $status = "success";

            }

            return response()->json(["status"=>$status]);


        }

    }


    public function updateDoctorBio(Request $request) {
        $data = $request->all();
        $res="";
        $status = "success";
        $validator = Validator::make($data, [
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'specialization' => 'required|exists:specializations,id',
        ]);
        $bio = null;
        if(array_key_exists('doctor_bio', $data))
            $bio = $data['doctor_bio'];
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);

          $res=  DocProfile::updateProfile($user->id, $data['specialization'], $bio,
                $data['city'], $data['state'], $data['country']);
            //dd($res);
        }

        return response()->json(['status'=>$status,'result'=>$res]);
    }

    public function getDoctorBio(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $res = ['status' => 'success'];
            $doc_profile = DocProfile::getProfile($user->id);
            if(!empty($doc_profile)) {
                $res['specialization_id'] = $doc_profile->specialization_id;
                $res['bio'] = $doc_profile->bio;
                $res['city'] = $doc_profile->city;
                $res['state'] = $doc_profile->state;
                $res['country'] = $doc_profile->country;
            }

        return response()->json(array("result"=>$res));
    }


    public function updateProfileImage(Request $request) {
        $profile_pic='';
        $data = $request->all();
        $validator = Validator::make($data, [
            'profile_pic' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error!";
            if ($request->file('profile_pic')->isValid()) {
                $filename = $request->profile_pic->getFilename(); // getClientOriginalName
                $filename = $filename.".".$request->profile_pic->extension();
                $profile_pic = $request->profile_pic->storeAs('dp', $filename, 's3');
                $doc=Doctor::find($user->id);
                $doc->picture = $filename;
                $doc->save();
                $status = "success";
            }
        }

        return response()->json(['status'=>$status,'result'=>$profile_pic]);
    }


    public function updateDocQualifications(Request $request) {

        $user = JWTAuth::toUser($request->token);
        $status = "success";

        foreach($request->input('qualifications.*') as $key => $qualification) {
            $f = 'qualification_files.'.$key;
            //dd($f);
            if($request->hasFile($f)) {
                $f = $request->file($f);
                $filename = $f->getFilename(); // getClientOriginalName
                $filename = $filename.".".$f->extension();
                $cert_doc = $f->storeAs(''.$user->id, $filename, 's3');
                $reg_number = "Unknown";
                if($request->has('qualification_certs.'.$key))
                    $reg_number = $request->input('qualification_certs.'.$key);
                DocQualification::createQualification($user->id, $qualification, $reg_number, $filename);
            }
        }
        return response()->json(['status'=>$status]);
    }


    public function getDocQualifications(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(array("result"=>DocQualification::getQualifications($user->id)));
    }


    public function deleteDocQualifications(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'q_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $data = $request->all();
            $id = $data['q_id'];
            $qualification = DocQualification::find($id);
            if (array_key_exists("id", $data) && ($qualification != null)) {

                DocQualification::deleteQualification($user->id, $id);
                $status = "success";
            }
        }
        return response()->json(['status'=>$status]);
    }


    public function updateDocAccreditations(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = "success";
        foreach($request->input('accr_types.*') as $key => $accr_type) {
            $f = 'accr_files.'.$key;
            $accr_valid_upto = $request->input('accr_valid_uptos.'.$key);
            $accr_number = $request->input('accr_numbers.'.$key);
            $accr_state = $request->input('accr_states.'.$key);
            $accr_country = $request->input('accr_countries.'.$key);

            if($request->hasFile($f)) {

                $f = $request->file($f);
                $filename = $f->getFilename();
                $filename = $filename.".".$f->extension();
                $insurance_doc = $f->storeAs(''.$user->id, $filename, 's3');

                DocAccreditation::createAccreditation($user->id, $accr_type, $accr_number, $filename,
                    $accr_valid_upto, $accr_state, $accr_country);
            }
        }

        return response()->json(['status' => $status]);
    }

    public function getDocAccreditations(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(DocAccreditation::getAccreditations($user->id));
    }




    public function deleteDocAccreditations(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'accr_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $data = $request->all();
            $id = $data['accr_id'];
            $qualification = DocAccreditation::find($id);
            if (array_key_exists("id", $data) && ($qualification != null)) {

                DocAccreditation::deleteAccreditation($user->id, $id);
                $status = "success";
            }
        }
        return response()->json(['status'=>$status]);
    }


    public function getExperiences(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = "success";
        return response()->json(array("result"=>DocExperience::getExperiences($user->id)));
    }

    public function updateExperiences(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = "success";
        // Delete all earlier entries
        DocExperience::deleteAllExperiences($user->id);
        foreach($request->input('exp_hospitals.*') as $key => $hospital_name) {
            $designation = $request->input('exp_designations.'.$key);
            $city = $request->input('exp_locations.'.$key);
            $from_month = $request->input('exp_from_months.'.$key);
            $from_year = $request->input('exp_from_years.'.$key);
            $to_month = $request->input('exp_to_months.'.$key);
            $to_year = $request->input('exp_to_years.'.$key);
            $duration = intval($request->input('exp_durations.'.$key));

            DocExperience::createExperience($user->id, $hospital_name, $designation, $city ?: '',
                $duration ?: null, $from_month, $from_year, $to_month, $to_year);
        }
        return response()->json(['status'=>$status]);
    }

    public function deleteExperiences(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'exp_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $data = $request->all();
            $id = $data['exp_id'];
            $experience = DocExperience::find($id);
            if (array_key_exists("id", $data) && ($experience != null)) {

                DocExperience::deleteExperience($user->id, $id);
                $status = "success";
            }
        }

        return response()->json(['status'=>$status]);
    }



    // Govt ID
    public function getGovtId(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(array("result"=>DocGovt::getAllGovtId($user->id)));
    }

    public function updateGovtId(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = 'success';
        $data = $request->all();
        $validator = Validator::make($data, [
            'id_type' => 'required',
            'id_number' => 'required',
        ]);
        foreach($request->input('id_type.*') as $key => $accr_type) {
            $f = 'govt_document.'.$key;
            $id_type = $request->input('id_type.'.$key);
            $id_number = $request->input('id_number.'.$key);
            if ($request->hasFile($f)) {
                $f = $request->file($f);
                $filename = $f->getFilename();
                $filename = $filename.".".$f->extension();
                //DocGovt::deleteAllGovtIds($user->meldoc_id);
                DocGovt::createGovtId($user->id, $id_type, $id_number, $filename);
                $policy_doc = $f->storeAs(''.$user->id, $filename, 's3');
            }
        }
        return response()->json(['status' => $status]);
    }

    public function deleteGovtId(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'gov_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $id = $data['gov_id'];
            $gid = DocGovt::find($id);
            if (array_key_exists("id", $data)&& ($gid != null)) {
                $id = $data['gov_id'];
                DocGovt::deleteGovtId($user->id, $id);
                $status = "success";
            }
        }

        return response()->json(['status'=>$status]);
    }
}