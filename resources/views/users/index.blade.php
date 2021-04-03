@extends('template.app')

@section('title')
Listar Usuários
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item active">Usuários </li>
</ol>
@endsection

@section('content')
<div class="container" style="min-height: 300px">
   
        <div class="text-center text-secondary mb-3 mt-3">
            
            {{'Total de '.$users->total().' registros - Exibindo '.$users->perPage().' por página'}}
        </div>

        <table class="table table-hover table-bordered" align = 'center'>
            <thead align = 'center'>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Criação</th>
                    <th>Nível</th>
                    <th colspan ="100%">Ações</th>
                </tr>
            </thead>
            
            <tbody align = 'center'>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{dateToPTBR($user->created_at)}}</td>
                    <td>{{ $user->roleName($user)}}</td>
                    <td align = ''>
                        <a href="{{route('user.show', $user->id)}}" class="btn btn-light border">Visualizar</a>
                        <a href="{{(Auth::user()->id==$user->id)? route('user.edit', $user->id) : '#'}}" class="btn btn-primary {{(Auth::user()->id==$user->id)? '':'disabled'}}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <div class="os-footer">
        {{$users->links()}}
    </div>
</div>

@endsection