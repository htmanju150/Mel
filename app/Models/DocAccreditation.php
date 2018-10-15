<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocAccreditation extends Model
{
	public static function createAccreditation($doc_id, $accr_type, $accr_number, $accr_file,
											   $accr_valid_upto, $accr_state, $accr_country) {
		$docAccreditation = new DocAccreditation;
		
		$docAccreditation->doc_id = $doc_id;
		$docAccreditation->accr_type = $accr_type;
		$docAccreditation->accr_number = $accr_number;
		$docAccreditation->accr_file = $accr_file;
		$docAccreditation->accr_valid_upto = $accr_valid_upto;
		$docAccreditation->accr_state = $accr_state;
		$docAccreditation->accr_country = $accr_country;
		$docAccreditation->save();
	}
	
    public static function deleteAccreditation($doc_id, $id) {
		$accreditation = DocAccreditation::find($id);
        if(($accreditation->doc_id == $doc_id)&&($accreditation->is_verified ==0 ))
            $accreditation->delete();
	}
	
	public static function getAccreditations($doc_id) {
		return DocAccreditation::where('doc_id', $doc_id)->get();
	}
}
