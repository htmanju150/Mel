<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    public static function getAllSpecializations() {
		return Specialization::all();
	}
	
	public static function getSpecialization($id) {
		return Specialization::find($id);
	}
}
