@extends('template.app')

@section('content')

@section('title')
Posts
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('post.index')}}">Posts</a></li>
    <li class="breadcrumb-item active">Criar Post </li>
</ol>
@endsection

<div class="container">

    @foreach( $fotos as $foto )
        {{-- {{ $foto->foto }} --}}
    
        <img src={{ url("storage/categories/{$foto->foto}") }} alt={{ $foto->foto }}>
    @endforeach

    <form action={{route('fotos.store')}} method="POST" enctype="multipart/form-data">
        @csrf

       
        <div class="form-group mt-1 mb-2 col-6">
            <label for="imagem">Imagem</label>
            <input type="file" class="form-control" value="" id="imagem" name="image">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{route('post.index')}}" class="btn btn-light border">Cancelar</a>
        </div>

    </form>

</div>
@endsection