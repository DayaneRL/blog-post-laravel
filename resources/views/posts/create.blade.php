@extends('template.app')

@section('content')

@section('title')
Posts
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
    <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
    <li class="breadcrumb-item active">Criar Post </li>
</ol>
@endsection

<div class="container">
   
    <form action="{{isset($post) ? route('post.update',$post->id) : route('post.store')}}" id="formPOST" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post))
         @method('PUT') 
        @endif
        
        <div class="form-group mt-1 mb-2">
            <label for="titulo">Título</label>
            <input type="text" class="form-control input-shadow" maxlength="100" placeholder="Título" value="{{ (isset($post)) ? $post->titulo : '' }}" id="titulo" name="titulo">
        </div>
        
        <div class="row">
            <div class="form-group mt-1 mb-2 col-12 col-md-6">
                <label for="tipo_post">Tipo Post</label>
                <select class="form-select form-control input-shadow" id="tipo_post" name="tipo_post_id" >
                    <option value="">Escolha o tipo</option>
                    @if(isset($tipo_post))
                        @foreach($tipo_post as $tipo)
                            <option value="{{$tipo->id}}" {{(isset($post) && $tipo->id==$post->tipo_post_id)? 'selected':''}}>{{$tipo->nome}}</option>
                        @endforeach
                    @endif
              </select>
            </div>
       

            <div class="form-group mt-1 mb-2 col-md-6 div-imagem">
                <label for="imagem">Imagem</label>
                
                @if(isset($post->fotos))
                    <div class="input-group">
                        <input type="text" class="form-control p-1 input-shadow" id="read-imagem" name="image" value="{{isset($post->fotos) ? $post->fotos->foto : ''}}" readonly>
                        <div class="input-group-append input-shadow">
                            <div class="input-group-text p-0" style="background-color: #fff;">
                                <button type="button" class="btn btn-default input-img-edit float-right pt-1">
                                    <i class="fas fa-edit p-0"></i>
                                </button>
                            </div>
                            <div class="input-group-text p-0" style="background-color: #fff;">
                                <button type="button" class="btn btn-default input-img-del float-right pt-1">
                                    <i class="far fa-trash-alt p-0"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                
                @else
                    <div class="input-group">
                        <input type="file" class="form-control p-1 input-shadow" id="imagem" name="image" >
                        {{-- <a class="btn btn-white border input-shadow" style="width:82%" href="#modal_image" data-toggle="modal">Adicionar imagem</a> --}}
                        <div class="input-group-append  input-shadow">
                            <div class="input-group-text p-0" style="background-color: #fff;">
                                <button type="button" class="btn btn-default input-img-del float-right pt-1">
                                    <i class="far fa-trash-alt p-0"></i>
                                </button>
                            </div>
                        </div>
                    </div> 
                
                @endif

            </div>
        </div>

        <div class="form-group mt-1 mb-2">
            <label for="autor">Autor</label>
            <input type="text" class="form-control input-shadow" placeholder="Autor" value="{{ isset($post) ? $post->autor : (Auth::user() ? Auth::user()->name : '') }}" id="autor" name="autor" @auth readonly @endauth>
        </div>

        <div class="form-group mt-1 mb-2">
            <label for="post">Post</label>
            <textarea class="form-control input-shadow" id="post"  name="post" style="height: 100px">{{ isset($post) ? $post->post : '' }}</textarea>
        </div>
        
        <div class="text-center mb-1">
            <button type="submit" class="btn btn-main-color show-shadow">Salvar</button>
            <a href="{{route('post.index')}}" class="btn btn-light border show-shadow">Cancelar</a>
        </div>

    </form>

</div>
@endsection
@section('scripts')
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<script src="{{ asset('js/validacao.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

@endsection