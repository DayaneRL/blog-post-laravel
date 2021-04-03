@extends('template.app')

@section('content')

@section('title')
@auth
{{($user->id == Auth::user()->id) ? 'Meu' : ''}}
@endauth
Perfil
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item active">Perfil</li>
</ol>
@endsection

<div class="card show-shadow p-4 card-show-profile">
    <div class="row">

        <div class="col-md-6 text-center div-first-column">
            <img class="profile-user-img img-fluid img-circle show-shadow"
                src="{{($user->id_foto)? asset('/storage/categories/'.$user->foto->foto) : asset('img/transferir.jfif') }}"
                alt="{{ $user->name }}">
        
            <h4>{{$user->name}}</h4>
            @if( Auth::user()->id==$user->id)
                @include('users/modal_image',['img'=>($user->id_foto)?$user->foto->foto:''])
                <a class="btn btn-secondary" href="#modal_image" data-toggle="modal">{{($user->id_foto)?'Editar':'Add'}} imagem</a>
            @endif
        </div>

        <div class="col-md-6 p-5 text-center">
            <a href="{{route('post.user',[$user->name,$user->id])}}" class="btn btn-info show-shadow mb-3">Posts de {{$user->name}}</a>
            <p class="p-show"><b>Email:</b> {{ $user->email }}</p>
            <p class="p-show"><b>Nível:</b> {{ $user->roleName($user) }}</p>
            <p class="p-show mb-4"><b>Data de criação:</b> {{ dateToPTBR($user->created_at) }}</p>
            @if( Auth::user()->id==$user->id || $user->minRoleID($user) > Auth::user()->minRoleID(Auth::user()))
                <div class="row offset-md-3">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-main-color show-shadow" style="width:100px">
                        <i class="fas fa-edit mr-1 ml-2"></i>
                    </a>
                    <form action="{{route('user.destroy', $user->id)}}" id="delete-user" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger show-shadow" id="del-comment" style="width:100px">
                            <i class="fas fa-trash mr-2 ml-2"></i></button>
                    </form>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<link rel="stylesheet" href="{{ asset('plugins/jquery-confirm-v3.3.4/css/jquery-confirm.css')}}">
<script src="{{ asset('plugins/jquery-confirm-v3.3.4/js/jquery-confirm.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/croppie.js') }}"></script>
@endsection