<?php

namespace Modules\Publications\Http\Controllers;

use App\Models\DocPublication;
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

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('publications::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('publications::create');
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
        return view('publications::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('publications::edit');
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



    public function updatePublications(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $status = "success";
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'link' => 'required',
            'description' => 'required',
            'journal_name' => 'required',
        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $f = 'citation_doc';
            if($request->hasFile($f)) {
                $f = $request->file($f);
                $filename = $f->getFilename();
                $filename = $filename.".".$f->extension();
                $publication_doc = $f->storeAs(''.$user->id, $filename, 's3');
                DocPublication::createPublication($user->id, $data['title'], $data['journal_name'],
                    $data['description'], $data['link'], $filename);
            } else {
                $status = "Missing file";
            }
        }
        return response()->json(['status'=>$status]);
    }

    public function deletePublications(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
            'pub_id' => 'required',

        ]);
        if ($validator->fails()) {
            $status = $validator->errors();
            return response()->json(['status'=>$status]);
        } else {
            $user = JWTAuth::toUser($request->token);
            $status = "Unknown Error";
            $data = $request->all();
            $id = $data['pub_id'];
            $publication = DocPublication::find($id);
            if (array_key_exists("id", $data)&& ($publication != null)) {
                $id = $data['pub_id'];
                DocPublication::deletePublication($user->id, $id);
                $status = "success";
            }
        }
        return response()->json(['status'=>$status]);
    }

    public function getPublications(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(array("result"=>DocPublication::getPublications($user->id)));
    }
}
