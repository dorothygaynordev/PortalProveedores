@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/reset.css') }}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content">

                <section class="s">

                </section>

                <section class="ss">
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            
                                    <input type="hidden" name="token" value="{{ $token }}">
                                <div class="campo">
                                    <div>
                                        <label for="email" class="text">{{ __('Correo Electronico') }}</label>
                                    </div>
                                    
                                    <div class="inputd">
                                        <input id="email" type="email" class="input form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                        
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                        <div class="campo">
                            <div>
                                <label for="password" class="text">{{ __('Nueva Contraseña') }}</label>
                            </div>
                            <div class="inputd">
                                <input id="password" type="password" class="input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="campo">
                            <div>
                                <label for="password-confirm" class="text">{{ __('Confirmar Contraseña') }}</label>
                            </div>
                            
                            <div class="inputd">
                                <input id="password-confirm" type="password" class="input form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="buttonr">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Restabelcer Contraseña') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
