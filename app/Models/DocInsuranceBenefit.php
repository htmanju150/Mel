<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocInsuranceBenefit extends Model
{
    static function getInsuranceBenefits($doc_insurance_id) {
		$benefits = DocInsuranceBenefit::where('doc_insurance_id', $doc_insurance_id)->get();
		if($benefits) {
			foreach($benefits as $benefit) {
				$b = Benefit::getBenefit($benefit->benefit_id);
				if($b)
					$benefit->{'policy_benefit'} = Benefit::getBenefit($benefit->benefit_id)->policy_benefit;
			}
		}
		return $benefits;
	}
    
    static function deleteInsuranceBenefits($doc_insurance_id) {
        DocInsuranceBenefit::where('doc_insurance_id', $doc_insurance_id)->delete();
    }
}
