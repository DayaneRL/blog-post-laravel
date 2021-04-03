<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\TipoPost;
use App\Foto;
use App\User;

class PostController extends Controller
{
    private $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function index()
    {
        $posts = $this->post->paginate(5);
        $categorias = TipoPost::all();
       
        return view('posts.index', compact('posts','categorias'));
    }

    public function categoria($categoria)
    {
        $tipo_post = TipoPost::where('nome',$categoria)->first();
        $posts = $this->post->where('tipo_post_id', $tipo_post->id)->paginate(5);
       
        return view('posts.index', compact('posts'));
    }

    public function user($name, $id)
    {
        $user_posts = User::find($id);
        $posts = $this->post->where('id_user', $id)->paginate(5);
        if($posts->total() == 0){
            return view('posts.index', compact('posts'))->with('warning','Esse usuário ainda não possui nenhum post');
        }
       
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        if(!Auth::user()){
            return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
        }
        $user = (Auth::user()) ? Auth::user() : '';
        $tipo_post = TipoPost::all();
        
        return view('posts.create', compact('user', 'tipo_post'));
    }

    public function store(PostRequest $request)
    {
        try {
            $post = new Post;
            DB::beginTransaction();
           
            $post->titulo = $request->titulo;
            $post->autor = $request->autor;
            $post->post = $request->post;
            $post->tipo_post_id = $request->tipo_post_id;
            $post->id_user = Auth::user()->id;

            //validacao imagem
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $name = date('HisYmd');
               
                $extension = $request->image->extension();
                $nameFile = "{$name}.{$extension}";
                //arquivo armazenado em storage/app/public/categories/nomearquivo.extensao
                $upload = $request->image->storeAs('categories', $nameFile);
                // se NÃO deu certo o upload (Redireciona de volta)
                if ( !$upload ){
                    return redirect()->back()
                        ->with('error', 'Falha ao fazer upload')->withInput();
                }else{
                    $foto = new Foto;
                    $foto->foto = $nameFile;
                    $foto->save();
                    // echo $foto->id;
                }
            }

            if(isset($foto)) $post->id_foto = $foto->id;
            $post->save();

            DB::commit();
            return redirect()->route('post.index')->with('success', "Post cadastrado com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        if(!Auth::user()){
            return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
        }

        $post = Post::findOrFail($id);
        $tipo_post = TipoPost::all();

        return view('posts.create', compact('post','tipo_post'));
    }

    public function show($id)
    {
        if(Post::find($id) !== null){
            $post = Post::find($id);
            
            return view('posts.show', compact('post'));
        }else{
            return redirect()->route('post.index')->with('warning',"Post não encontrado!");
        }
        
    }

    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::find($id);

            if(!Auth::user()){
                return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
            }

            DB::beginTransaction();
           
            if(isset($request->titulo)) $post->titulo = $request->titulo;
            if(isset($request->autor)) $post->autor = $request->autor;
            if(isset($request->post)) $post->post = $request->post;
            if(isset($request->tipo_post_id)) $post->tipo_post_id = $request->tipo_post_id;
            $post->id_user = Auth::user()->id;

            //validacao imagem
            if ($request->hasFile('image') && $request->file('image')->isValid()) {

                $name = date('HisYmd');
                $extension = $request->image->extension();
                $nameFile = "{$name}.{$extension}";
                
                $upload = $request->image->storeAs('categories', $nameFile);
                
                if ( !$upload ){
                    return redirect()->back()
                        ->with('error', 'Falha ao fazer upload')->withInput();
                }else{
                    if(isset($post->id_foto)){
                        $fotoExistente = Foto::find($post->id_foto);
                        unlink('../public/storage/categories/'.$fotoExistente->foto);//apaga foto da maquina
                        $fotoExistente->delete();//apaga foto do banco 
                        $post->id_foto = null;//seta post com nenhuma foto
                    }

                    $foto = new Foto;
                    $foto->foto = $nameFile;
                    $foto->save(); //cria nova foto no banco
                    if(isset($foto->foto)) $post->id_foto = $foto->id; //insere nova foto no post
                }
            }
            
            if($request->image == null) $post->id_foto = null; //se nenhuma imagem, 
            $post->update();

            DB::commit();
            return redirect()->route('post.show', $id)->with('success', "Post atualizado com sucesso!");
        }  catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try{
            if(!Auth::user()){
                return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
            }

            $post = Post::find($id);
            DB::beginTransaction();
    
            if(isset($post->fotos)){
                $post->fotos->delete();
            }
            if(isset($post->comentarios)){
                foreach($post->comentarios as $comentario){
                    $comentario->delete();
                }
            }

            $post->delete();

            DB::commit();
            return redirect()->route('post.index')->with('success', "Post deletado com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }


}
