<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocPublication extends Model
{
    public static function createPublication($doc_id, $title, $journal_name, $description, $link, $filename) {
		$publication = new DocPublication;
		$publication->doc_id = $doc_id;
		$publication->title = $title;
		$publication->description = $description;
        $publication->journal_name = $journal_name;
		$publication->month_year = 0000; // TODO
		$publication->link = $link;
		$publication->citation_doc = $filename;
		$publication->save();
	}
    
    public static function deletePublication($doc_id, $id) {
        $publication = DocPublication::find($id);
        if($publication->doc_id == $doc_id)
            $publication->delete();
    }
    
    public static function getPublications($doc_id) {
        return DocPublication::where('doc_id', $doc_id)->get();
    }
}
