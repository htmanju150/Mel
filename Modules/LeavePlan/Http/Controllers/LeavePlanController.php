<?php

namespace Modules\LeavePlan\Http\Controllers;

use App\Models\DocLeave;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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

class LeavePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    use FormatDates;

    public function index()
    {
        return view('leaveplan::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('leaveplan::create');
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
        return view('leaveplan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('leaveplan::edit');
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



    public function getDocLeaves(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(DocLeave::getAllLeaves($user->id));
    }

    public function updateDocLeaves(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $data = $request->all();
        $status = "success";
        $validator = Validator::make($data, [
            'start_leave' => 'required|date_format:Y-m-d',
            'end_leave' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $status = $validator->errors();
        } else {
            $start_at=strtotime($data['start_leave']);
            $end_at=strtotime($data['end_leave']);
            $date_array=[];

            $get_all_leaves=DocLeave::getAllLeaves($user->id);
//dd($get_all_leaves);
            foreach($get_all_leaves as $leaves){

                $start_leave=explode(" ",$leaves['start_leave'])[0];
                $end_leave=explode(" ",$leaves['end_leave'])[0];

                $check=$this->get_start_end_arr($start_leave,$end_leave,$get_all_leaves);
                if((in_array($data['start_leave'],$check))|| (in_array($data['end_leave'],$check))){

                    return response()->json(['status'=>"Leaves are already added  for given date"]);
                }

            }
            DocLeave::addLeave($user->id, $data['start_leave'], $data['end_leave'],$start_at,$end_at);
            }


        return response()->json(['status'=>$status]);
    }

    public function deleteDocLeaves(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'leave_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $data = $request->all();
            $id = $data['leave_id'];
            $leave = DocLeave::find($id);
            if (array_key_exists("id", $data) && ($leave != null)) {
                $id = $data['id'];
                DocLeave::deleteLeave($user->id, $id);
                $status = "success";
            }
        }

        return response()->json(['status'=>$status]);
    }
}
