<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    // use SoftDeletes;
    protected $table    = 'comentarios';

    protected $fillable = [
        'autor','comentario', 'id_user', 'post_id'
    ];
    public $timestamps   = true;

    public function users() {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }

    public function posts(){
        //
    }

}
