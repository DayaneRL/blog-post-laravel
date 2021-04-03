@extends('template.app')

@section('content')

@section('title')
Criar usuário
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item"><a href="{{route('user.index')}}">Usuários</a></li>
  <li class="breadcrumb-item active">Cadastrar </li>
</ol>
@endsection

<div class="container">
    <form method="POST" id="formUser" action="{{ route('user.store') }}">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Nome') }}</label>

            <div class="col-md-5">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror input-shadow" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

            <div class="col-md-5">
                <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror input-shadow" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Senha') }}</label>

            <div class="col-md-5">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-shadow" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirme a sua senha') }}</label>

            <div class="col-md-5">
                <input id="password-confirm" type="password" class="form-control input-shadow" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row">

        <label class="col-md-3 col-form-label text-md-right">Nível</label>

            <div id="roles" class="col-md-5 ml-4">
                @foreach ($roles as $role)
                    @if($role->id > Auth::user()->minRoleID(Auth::user()))
                    <div class="chb">
                        <input class="form-check-input icheck input-shadow" name="roles[]" type="checkbox" value="{{ $role->id}}" id="ckb-{{$role->id}}">
                        <label class="form-check-label d-block" style="width: fit-content;">
                            {{ $role->nome }}
                            <span class="text-secondary d-block mb-1"style="margin-left: 20px;">
                                <i class="fas fa-level-down-alt"></i> {{ $role->descricao }}
                            </span>

                        </label>
                    </div>
                    @endif
                @endforeach
            </div>

            @if ($errors->has('roles'))
                <div class="invalid-feedback">
                {{ $errors->first('roles') }}
                </div>
            @endif

        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
                <button type="submit" class="btn btn-main-color mr-2 show-shadow" style="width: 30%">
                    Cadastrar
                </button>
                <a href="{{route('user.index')}}" class="btn btn-light border show-shadow" style="width: 30%">
                    Cancelar
                </a>
            </div>
        </div>
    </form>

</div>
@endsection

@section('scripts')
  <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

  <script src="{{ asset('js/validacao.js')}}"></script>
  <script src="{{ asset('js/user_show.js')}}"></script>
@endsection