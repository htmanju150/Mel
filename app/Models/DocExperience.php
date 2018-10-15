<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocExperience extends Model
{
    public static function createExperience($doc_id, $hospital_name, $designation, $city, $duration,
                                            $from_month, $from_year, $to_month, $to_year) {
		$experience = new DocExperience;
		$experience->doc_id = $doc_id;
		$experience->hospital_name = $hospital_name;
		$experience->designation = $designation;
		$experience->city = $city;
		$experience->duration = $duration;
        $experience->from_month = $from_month;
        $experience->from_year = $from_year;
        $experience->to_month = $to_month;
        $experience->to_year = $to_year;
		$experience->save();
	}
    
    public static function deleteAllExperiences($doc_id) {
        DocExperience::where('doc_id', $doc_id)->delete();
    }
    
    public static function deleteExperience($doc_id, $id) {
        $experience = DocExperience::find($id);
        if($experience->doc_id == $doc_id)
			$experience->delete();
    }
    
    public static function getExperiences($doc_id) {
        return DocExperience::where('doc_id', $doc_id)->get();
    }
}
