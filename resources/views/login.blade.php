@extends('layouts.app')
<title>Proveedores Login</title>
@section('content')
<link rel="stylesheet" href="{{ asset('assets/login.css') }}">
<link rel="stylesheet" href="{{asset('assets/sass/app.scss')}}">
<script>{{asset('assets/js/app.js')}}</script>
    <div class="principal">
        <div class="row justify-content-center">
            <div class="">
                <div class="ca">
                    
                    <div class="card-body">
                        <div class="user">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-person-circle icons" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                              </svg>
                              <p>Iniciar Sesión</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- <input  name="provider_id" value="{{ $provider_id }}"> --}}


                            <div class="campo">
                                <div>

                                    <label class="text" for="email">{{ __('Correo') }}</label>
                                </div>

                                <div class="inputd">
                                    <input id="email" type="email"
                                        class="input form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="algo@example.com">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="campo">
                                <div>
                                    <label for="password" class="text">{{ __('Password') }}</label>
                                </div>

                                <div class="inputd">
                                    <input id="password" type="password"
                                        class="input form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="********">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="buttons">
                                
                                <div>
                                    <div class="">
                                        @if (Route::has('login'))
                                        <button type="submit" class="login btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        @endif
                                        
                                        @if (Route::has('register'))
                                        <button class="register btn btn-secondary" style="list-style:none">
                                            <a class="nav-link"
                                            href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                        </button>
                                        @endif
                                        
                                    </div>
                                </div>
                                <div class="b">
                                    
                                    @if (Route::has('password.request'))
                                    <a class="reco btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Recuperar Contraseña') }}
                                    </a>
                                    @endif
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('loginForm');
        const providerIdInput = loginForm.querySelector('input[name="provider_id"]');

        const providerId = 'provider_id'; // Reemplaza con el provider_id deseado

        // Actualizar el valor del campo provider_id antes del envío del formulario
        providerIdInput.value = providerId;

        // Agregar un evento de clic al botón de login
        const loginButton = document.querySelector('.login.btn');
        loginButton.addEventListener('click', function () {
            loginForm.submit(); // Enviar el formulario
        });
    });
</script>
