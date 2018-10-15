<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    static function getBenefit($id) {
		return Benefit::find($id);
	}
}
