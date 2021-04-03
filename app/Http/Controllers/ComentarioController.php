<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Comentario;
use App\Post;

class ComentarioController extends Controller
{
    public function store($texto, $idpost)
    {        
        DB::beginTransaction();
        try {
            
            if(!Auth::user()){
                return ['erro'=>'Não foi possível realizar essa ação! Você precisa estar logado.'];
            }
            
            $comentario = new Comentario;
            $comentario->autor = Auth::user()->name;
            $comentario->comentario = $texto;
            $comentario->id_user = Auth::user()->id;
            $comentario->post_id = $idpost;
            $comentario->save();          
            
            DB::commit();
            return ['deucerto'=>"Comentário cadastrado com sucesso", 'idcriado'=>$comentario->id, 
            'autornome'=> $comentario->autor, 'autorid'=> Auth::user()->id,
            'created_at'=>datetimeToPTBR($comentario->created_at)];
        }  catch (ModelNotFoundException $exception) {
            return ['erro'=>'Não foi possível realizar essa ação!'];
        }
       
    }

    public function destroy($id)
    {
        if(!Auth::user()){
            return ['erro'=>'Não foi possível realizar essa ação! Você precisa estar logado!'];
        }

        try{

            $comentario = Comentario::find($id);
            $post = Post::find($comentario->post_id);
            $comentario->delete();

            return ['deucerto'=>"Comentário excluído com sucesso", 'idcriado'=>$comentario->id, 'count_comments'=>$post->comentarios->count()];
        }catch (ModelNotFoundException $exception) {
            return ['status'=>'erro','msg'=>'Não foi possível realizar essa ação!'];
        }
    }
}
