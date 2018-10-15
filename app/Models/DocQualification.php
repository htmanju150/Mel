<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocQualification extends Model
{
    public static function createQualification($doc_id, $type, $reg_number, $degree_certificate) {
		$qualification = new DocQualification;
		$qualification->doc_id = $doc_id;
		$qualification->type = $type;
		$qualification->reg_number = $reg_number;
		$qualification->degree_certificate = $degree_certificate;
		$qualification->save();
	}
    
    public static function deleteQualification($doc_id, $id) {
        $qualification = DocQualification::find($id);
        if(($qualification->doc_id == $doc_id)&&($qualification->is_verified ==0 ))
            $qualification->delete();
    }
    
    public static function deleteQualifications($meldoc_id) {
        return DocQualification::where('meldoc_id', $meldoc_id)->delete();
    }
    
    public static function getQualifications($doc_id) {
        return DocQualification::where('doc_id', $doc_id)->get();
    }
}
