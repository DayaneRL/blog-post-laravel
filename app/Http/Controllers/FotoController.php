<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Foto;

class FotoController extends Controller
{

    public function create()
    {
        $fotos = Foto::all();
        return view('posts.foto-create', compact('fotos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Define o valor default para a variável que contém o nome da imagem 
            $nameFile = null;
        
            // Verifica se informou o arquivo e se é válido
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                
                // Define um aleatório para o arquivo baseado no timestamps atual
                $name = uniqid(date('HisYmd'));
        
                // Recupera a extensão do arquivo
                $extension = $request->image->extension();
        
                // Define finalmente o nome
                $nameFile = "{$name}.{$extension}";
        
                // Faz o upload:
                $upload = $request->image->storeAs('categories', $nameFile);
                // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
        
                // Verifica se NÃO deu certo o upload (Redireciona de volta)
                if ( !$upload ){
                    return redirect()
                                ->back()
                                ->with('error', 'Falha ao fazer upload')
                                ->withInput();
                }else{
                     // $os = new Os;
                    // $os->nome_autor = $request->nome_autor;
                    // $os->save();
                    $foto = new Foto;
                    $foto->foto = $nameFile;
                    $foto->save();
                }
            }

            DB::commit();
            return redirect()->route('post.index')->with('success', "cadastrado com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}
