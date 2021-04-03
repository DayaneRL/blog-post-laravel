<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class TipoPost extends Model
{
    protected $table = 'tipo_post';

    protected $fillable = [
        'nome','descricao'
    ];

    public function Post() {
        return $this->belongsTo('App\Post', 'id','tipo_post_id');
    }

    public function allPosts($categ_id){
        $posts = Post::where('tipo_post_id', $categ_id)->get();
        return $posts;
    }

    public function lastPost($categ_id){
        $post = Post::where('tipo_post_id', 1)->orderBy('id', 'DESC')->get();
        return $post;
    }
}
