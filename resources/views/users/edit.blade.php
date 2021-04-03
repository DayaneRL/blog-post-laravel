@extends('template.app')

@section('content')

@section('title')
Editar usuário
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item"><a href="{{route('user.show',$user->id)}}">Perfil</a></li>
  <li class="breadcrumb-item active">Editar </li>
</ol>
@endsection

<div class="container">

    <form method="POST" id="formUserEdit" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">

        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Nome') }}</label>

            <div class="col-md-5">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror input-shadow" name="name" value="{{ ($user->name)? $user->name : old('name') }}" required autocomplete="name" autofocus>

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
                <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror input-shadow" name="email" value="{{ ($user->email)? $user->email :old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">{{ ($user->password)? 'Trocar senha' : 'Senha' }}</label>

            <div class="col-md-5">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-shadow" name="password" autocomplete="new-password">

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
                <input id="password-confirm" type="password" class="form-control input-shadow" name="password_confirmation" autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row">

            <label class="col-md-3 col-form-label text-md-right">Nível</label>
    
            <div id="roles" class="col-md-5 ml-4">
                @foreach ($roles as $key => $role)
                    <div class="chb">
                    @php echo '<input class="form-check-input icheck input-shadow" name="roles[]" type="checkbox" value="'.$role->id.'" id="ckb-'.$role->id.'"' .((in_array($role->id, $userRoles)) ? "checked" : "").'>'; @endphp
                    <label class="form-check-label d-block" style="width: fit-content;">
                        {{ $role->nome }}
                        <span class="text-secondary d-block mb-1"style="margin-left: 20px;">
                            {{ $role->descricao }}
                        </span>

                    </label>
                    </div>
                @endforeach
            </div>

            @if ($errors->has('roles'))
                <div class="invalid-feedback">
                {{ $errors->first('roles') }}
                </div>
            @endif

        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-3">
                <button type="submit" class="btn btn-main-color mr-2 show-shadow" style="width: 30%">
                    {{ __('Alterar') }}
                </button>
                <a href="{{route('user.show',$user->id)}}" class="btn btn-light border show-shadow" style="width: 30%">
                    {{ __('Cancelar') }}
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