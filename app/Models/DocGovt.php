<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocGovt extends Model
{
    public static function createGovtId($doc_id, $id_type, $id_number, $id_file) {
        $gid = new DocGovt;
        // Todo: If multiple entries are not required change id as doc_id
        $gid->doc_id = $doc_id;
        $gid->id_type = $id_type;
        $gid->id_number = $id_number;
        $gid->id_file = $id_file;
        $gid->save();
    }
    
    public static function deleteAllGovtIds($meldoc_id) {
        DocGovt::where('meldoc_id', $meldoc_id)->delete();
    }
    
    public static function getGovtId($meldoc_id) {
        return DocGovt::where('meldoc_id', $meldoc_id)->first();
    }
    
    public static function getAllGovtId($doc_id) {
        return DocGovt::where('doc_id', $doc_id)->get();
    }
    
    public static function deleteGovtId($doc_id, $id) {
        $gid = DocGovt::find($id);
        if($gid->doc_id == $doc_id)
			$gid->delete();
    }
}
