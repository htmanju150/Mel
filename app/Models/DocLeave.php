<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocLeave extends Model
{
    public static function deleteLeave($doc_id, $id) {
		$leave = DocLeave::find($id);
        if($leave->doc_id == $doc_id)
			$leave->delete();
	}
	
	public static function getAllLeaves($doc_id) {
        $today=strtotime(Date('Y-m-d'));
        //dd($today);
		return DocLeave::where('doc_id', $doc_id)->where('end_at','>=',$today)->orderBy('start_leave', 'desc')->take(100)->get();
	}


	
	public static function addLeave($doc_id, $start_leave, $end_leave,$start_at,$end_at) {
		$leave = new DocLeave;
		$leave->doc_id = $doc_id;
		$leave->start_leave = $start_leave;
		$leave->end_leave = $end_leave;
		$leave->start_at = $start_at;
		$leave->end_at = $end_at;
		$leave->save();
	}
}
