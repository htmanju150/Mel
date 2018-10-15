<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocProfile extends Model
{
	
	protected $fillable = ['doc_id'];

    public static function getProfile($meldoc_id) {
		return DocProfile::where('doc_id', $meldoc_id)->first();
	}
	
	public static function updateProfile($meldoc_id, $specialization_id, $bio,
										 $city = null, $state = null, $country = null) {
		$profile = DocProfile::firstOrNew(['doc_id'=>$meldoc_id]);
		$profile->specialization_id = $specialization_id;
		$profile->bio = $bio;
		$profile->city = $city;
		$profile->state = $state;
		$profile->country = $country;
		$profile->save();
		return $profile;
	}

    public static function createDocProfile($user,$url){
        //dd($user);
        $profile = new DocProfile();
        $profile->doc_id = $user->id;
        $profile->webpage = $url;
        $profile->save();

    }
	
	public static function updateUrl($meldoc_id, $webpage) {
		$profile = DocProfile::firstOrNew(['meldoc_id'=>$meldoc_id]);
		$profile->webpage = $webpage;
		$profile->save();
		return $profile;
	}


    public static function getCustomUrl($url){

        return DocProfile::where('webpage', $url)->first();

    }

    public static function getDoctorProfileId($id){

        return DocProfile::where('doc_id', $id)->first();

    }



}
