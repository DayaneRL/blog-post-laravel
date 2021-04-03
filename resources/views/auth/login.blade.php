@extends('template.app')

@section('content')

@section('title')
Login
@endsection

@section('breadcrumb')
<ol class="breadcrumb mb-4 show-shadow">
  <li class="breadcrumb-item active">Login </li>
</ol>
@endsection

<div class="container">

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

            <div class="col-md-5">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror input-shadow" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror input-shadow" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Lembrar-me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-3">
                <button type="submit" class="btn btn-primary show-shadow" style="width: 30%">
                    {{ __('Login') }}
                </button>
                <a href="{{route('post.index')}}" class="btn btn-light border show-shadow" style="width: 30%">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection
