@extends('template.app')

@section('content')

@section('title')
Posts
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item active">Posts </li>
</ol>
@endsection

<div class="container">

    <div class="row mb-2">

        @if(isset($categorias))
        @foreach($categorias as $categoria)
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="card text-white efeito show-shadow">
                <figure>
                    <h6 class="text-center">{{ $categoria->nome}}</h6> 
                    <div class="box-black"></div>
                    <a href="{{route('post.show', $categoria->Post->id)}}" target="_blank" alt={{$categoria->Post->titulo}}>
                        <img src={{ url("storage/categories/{$categoria->Post->fotos->foto}") }} alt={{ $categoria->Post->fotos->foto }} class="img-card"/>
                    
                    <figcaption>
                        <h4 class="text-center">{{ $categoria->Post->titulo}}</h4> 
                        {{-- <span>{{ $categoria->Post->post}}</span> --}}
                    </figcaption>
                    </a>
                </figure>
            </div>
        </div>
        @endforeach
        @endif

    </div>

    
    @foreach($posts as $post)
        <div id="post" class="card mb-2 col-md-12 p-0 show-shadow">
            
            <div class="card-body mr-0">
                <h3>{{$post->titulo}}</h3>
                <div class="d-flex align-items-center justify-content-between small">
                    <div>
                        <i class="far fa-calendar-alt mr-1"></i>{{ dateToPTBR($post->created_at) }}
                        &middot;
                        <i class="far fa-user mr-1"></i><a href="{{route('user.show', $post->users->id)}}">{{ $post->autor }}</a>
                    </div>
                </div>
                <hr/>

                <p>{{$post->post}}</p>
                <a href="{{route('post.show', $post->id)}}" >Ver Detalhes</a>
            </div>

            <div class="card-footer">
                <small><i class="fas fa-folder mr-1"></i>><a href="{{ route('post.categoria', $post->tipoPost->nome) }}">{{ $post->tipoPost->nome}}</a> /</small>
                <small><i class="fas fa-comment mr-1"></i>{{$post->comentarios->count()}} comentarios</small>
            </div>
            
        </div>
    @endforeach

    @if($posts->total() > 5)
    <div class="row text-secondary">
        <div class="col-sm-12 col-md-5">
            {{'Total de '.$posts->total().' registros - Exibindo '.$posts->perPage().' por página'}}
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="float-right show-shadow" style="height: 37px;">{{$posts->links()}}</div>
        </div>
    </div>
    @endif

</div>
@endsection