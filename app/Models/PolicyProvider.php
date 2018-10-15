<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyProvider extends Model
{
    //
	public static function getAllPolicyProviders() {
		return PolicyProvider::all();
		//orderBy('policy_provider', 'asc')->get();
	}
	public static function getPolicyProvider($id) {
		return PolicyProvider::find($id);
	}
}
