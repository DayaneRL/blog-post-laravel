@extends('template.app')

@section('content')

@section('title')
Posts
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
  <li class="breadcrumb-item"><a href="{{ route('post.categoria', $post->tipoPost->nome) }}">{{$post->tipoPost->nome}}</a></li>
  <li class="breadcrumb-item active"> {{$post->id}}-{{$post->titulo}}</li>
</ol>
@endsection

  <div class="show-shadow show-post mb-1" style="border: 1px solid #ddd; border-radius: 10px; padding: 10px 30px">
    <h3 class="text-center mb-3 mt-3">{{strtoupper ($post->titulo)}}</h3>

    <div class="mb-3 mt-1 align-items-center justify-content-between text-secondary text-center">
      <div>
        <i class="far fa-calendar-alt mr-1"></i>{{ dateString($post->created_at) }}
        &middot;
        <i class="fas fa-user mr-1" style="color:darkcyan"></i><a href={{route('user.show',$post->id_user)}}>{{$post->users->name}}</a>
        &middot;
        <i class="fas fa-comment mr-1"></i>{{$post->comentarios->count()}} comentarios
      </div>
    </div>
    <hr class="separator-1"/>

    @if(isset($post->fotos))
    <div class="parallax-container">
      <div class="parallax">
        <img src={{ url("storage/categories/{$post->fotos->foto}") }} alt={{ $post->fotos->foto }}>
      </div>
    </div>
    @endif

    <div class="row">

      <div class="col-12 col-md-10 p-3 text-center">
        <b>Categoria: </b><a href="{{ route('post.categoria', $post->tipoPost->nome) }}">{{$post->tipoPost->nome}}</a>
        <p style="font-size:20px;">{{$post->post}}</p>
      </div>

      <div class="col-12 col-md-2">
        <div class="row">
          <a class="btn btn-main-color show-shadow" href={{route('post.edit', $post->id)}}><i class="fas fa-edit mr-1 ml-2"></i></a>
          
          <form action="{{route('post.destroy', $post->id)}}" id="form-delete" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" id="post-del" class="btn btn-danger show-shadow"><i class="fas fa-trash mr-2 ml-2"></i></button>
          </form>
        </div>
      </div>
    </div>

    <br/>
    
    <div id="comentarios" >
      @if(isset($post->comentarios[0]))
      <a class="btn btn-secondary text-center comment-btn" data-toggle="collapse" href="#collapseComment" role="button" aria-expanded="false" style="width:100%">Comentários <i class="fas fa-angle-right float-right icon-btn"></i></a>

      <div class="collapse" id="collapseComment">
        @foreach($post->comentarios as $comentario)
        <div class="comentario col-md-12 offset-md-0">
            <div class="row" style="padding: 8px">

              <div class="col-12 col-md-2 mt-1 text-center pl-5">
                <i class="fas fa-user-circle fa-3x m-2"></i>
              </div>

              <div class="card col-12 col-md-9 comentario-area">
                
                <div class="card-header align-items-center justify-content-between small">
                  <div>
                    <a href={{route('user.show',$comentario->id_user)}}>{{$comentario->autor}}</a>
                    &middot;
                    <i class="far fa-calendar-alt mr-1"></i>{{ datetimeToPTBR($comentario->created_at) }}
                    @auth
                      @if($comentario->id_user == Auth::user()->id) 
                        @csrf
                        <input type="hidden" value={{$comentario->id}} id="comment_id"/>
                        <button class="btn btn-default float-right pb-0 pt-0" id="del-comment"><i class="fas fa-trash"></i></button>
                      @endif
                    @endauth
                  </div>
                </div>

                <div class="card-body">
                  <p>{{$comentario->comentario}}</p>
                </div>
                
              </div>

            </div>
        </div>
       @endforeach
      </div>

      @endif
    </div>
    
    <hr class="separator-2"/>
    <div class="row mt-2 mb-3 fazer-comentario">
        <div class="col-12 col-md-1 offset-md-1 text-center">
          <i class="fas fa-user-circle fa-3x m-1"></i>
          @auth 
          <a target="_blank" href={{route('user.show',Auth::user()->id)}}>{{Auth::user()->name}}</a>
          @else 
          <b>Login</b>
          @endauth
        </div>
        
        @csrf
        <div class="col-md-9 col-10">
          <input type="hidden" value={{$post->id}} id="post_id"/>
          <textarea class="form-control show-shadow" id="comment" name = "comentario" style="height: 80px"> </textarea>
        </div>
        
        <div class="col-md-1 p-0 col-1">
          <button class="btn btn-main-color show-shadow" id="send-comment" style="height: 80px;"><i class="far fa-paper-plane"></i></button>
        </div>
    </div>

  </div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/parallax.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.parallax').parallax();
  })
</script>
<link rel="stylesheet" href="{{ asset('plugins/jquery-confirm-v3.3.4/css/jquery-confirm.css')}}">
<script src="{{ asset('plugins/jquery-confirm-v3.3.4/js/jquery-confirm.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
@endsection