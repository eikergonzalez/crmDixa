<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noticias extends Model{
    use HasFactory;
    protected $table = 'noticias';
    public $timestamps = true;
    protected $primaryKey = "id";

    public function getNextId(){
        $next_id = DB::select("select nextval('seq_id_noticias')");
        return intval($next_id[0]->nextval);
    }
}
