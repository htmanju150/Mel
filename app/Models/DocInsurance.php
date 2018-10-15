<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocInsurance extends Model
{
    public static function createInsurance($doc_id, $insurance_type, $policy_provider_id,
                                           $filename, $policy_number = null, $valid_from = null, $valid_till = null) {
		$insurance = new DocInsurance;
		$insurance->doc_id = $doc_id;
		$insurance->type = $insurance_type;
        $insurance->policy_provider_id = $policy_provider_id;
        $insurance->policy_number = $policy_number;
        $insurance->valid_from = $valid_from;
        $insurance->valid_till = $valid_till;
		$insurance->policy_document = $filename;
		$insurance->save();
	}
    
    public static function getAllInsurances($doc_id) {
        return DocInsurance::where('doc_id', $doc_id)->get();
    }
    
    public static function deleteInsurance($doc_id, $id) {
        $insurance = DocInsurance::find($id);
        if($insurance->doc_id == $doc_id) {
            $insurance->delete();
            return true;
        }
        return false;
    }
}
