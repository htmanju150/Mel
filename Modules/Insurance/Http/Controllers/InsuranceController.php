<?php

namespace Modules\Insurance\Http\Controllers;

use App\Models\DocInsurance;
use App\Models\DocInsuranceBenefit;
use App\Models\PolicyProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\DocLeave;
use DateInterval;
use DatePeriod;
use DateTime;

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
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use JWTFactory;
use JWTAuth;
use Validator;
use JWTAuthException;
use App\Traits\FormatDates;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('insurance::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('insurance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('insurance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('insurance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }



    public function updateDocInsurances(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = "success";
        $data = $request->all();
        $validator = Validator::make($data, [
            'type' => 'required',
            'policy_provider_id' => 'required|exists:policy_providers,id',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
        } else {
            $f = 'insurance_file';
            if($request->hasFile($f)) {
                $f = $request->file($f);
                $filename = $f->getFilename();
                $filename = $filename.".".$f->extension();
                $insurance_doc = $f->storeAs(''.$user->id, $filename, 's3');
                DocInsurance::createInsurance($user->id, $data['type'], $data['policy_provider_id'], $filename);
            }
        }
        return response()->json(['status'=>$status]);
    }

    public function getDocInsurances(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $insurances = DocInsurance::getAllInsurances($user->id);
        foreach($insurances as $insurance) {
            $insurance->{'benefit'} = DocInsuranceBenefit::getInsuranceBenefits($insurance->id);
            $insurance->{'policy_provider'} = PolicyProvider::getPolicyProvider($insurance->policy_provider_id)->policy_provider;
        }
        return response()->json(array("result"=>$insurances));
    }

    public function deleteDocInsurances(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'ins_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $insurance = DocInsurance::find($request->ins_id);
            if ($request->has("ins_id")&& ($insurance != null)) {
                if (DocInsurance::deleteInsurance($user->id, $request->ins_id))
                    DocInsuranceBenefit::deleteInsuranceBenefits($request->ins_id);
                $status = "success";
            }
        }
        return response()->json(['status'=>$status]);
    }
}
