@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/register.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content">

                    <section class="s"> </section>
                    <section class="ss">


                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="campo">
                                    <div>
                                        <label for="name" class="text">{{ __('Nombre de usuario') }}</label>
                                    </div>
                                    <div class="inputd">
                                        <input id="name" type="text"
                                            class="input form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus
                                            placeholder="usuario">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="campo">
                                    <div>
                                        <label for="name" class="text">{{ __('Organización') }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="provider">Selecciona una organización:</label>
                                        <select name="provider_id" id="provider_id" class="form-control">
                                            @foreach ($providers as $provider)
                                                <option value="{{ $provider->ClaveProv }}">{{ $provider->NomProv }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="campo">
                                    <div>
                                        <label for="email" class="text">{{ __('Correo electronico') }}</label>
                                    </div>

                                    <div class="inputd">
                                        <input id="email" type="email"
                                            class="input form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="algo@example.com">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="campo">
                                    <div>
                                        <label for="password" class="text">{{ __('Contraseña') }}</label>
                                    </div>
                                    <div class="inputd">
                                        <input id="password" type="password"
                                            class="input form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password" placeholder="********">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="campo">
                                    <div>
                                        <label for="password-confirm"
                                            class="text">{{ __('Confirmar contraseña') }}</label>
                                    </div>
                                    <div class="inputd">
                                        <input id="password-confirm" type="password" class="input form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="********">
                                    </div>
                                </div>

                                <div class="buttonr">
                                    <div>
                                        <div class="buttonr">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Registrarme') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
