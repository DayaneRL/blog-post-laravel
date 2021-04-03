<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    protected $table    = 'post';

    protected $fillable = [
        'titulo','autor','post', 'id_user', 'tipo_post_id', 'id_foto'
    ];
    public $timestamps   = true;

    public function users() {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }

    public function fotos() {
        return $this->belongsTo('App\Foto', 'id_foto', 'id');
    }

    public function comentarios(){
        return $this->hasMany('App\Comentario','post_id','id');
    }

    public function tipoPost() {
        return $this->belongsTo('App\TipoPost', 'tipo_post_id', 'id');
    }
}
