@extends('layouts.app')

@section('content')


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script>
        $(document).ready(function() {
            $("input.telefone")
                .mask("(99) 9999-9999?9")
                .focusout(function(event) {
                    var target, phone, element;
                    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                    phone = target.value.replace(/\D/g, '');
                    element = $(target);
                    element.unmask();
                    if (phone.length > 10) {
                        element.mask("(99) 99999-999?9");
                    } else {
                        element.mask("(99) 9999-9999?9");
                    }
                });
        });

    </script>


    <div class="row">
        <div class="col-lg-12 margin-tb">



            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div class="card-body">


                            <div class="card-title titulo-destaque text-center">
                                PROGRAMA CORPORATIVO GESTANTES E FUTUROS PAIS
                            </div>
                            <hr />


                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">

                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Usuário') }}</label>

                                    <div class="col-md-6">



                                        <input id="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>




                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Manter logado') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit"
                                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase">
                                            {{ __('Entrar') }}
                                        </button>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link text-success" href="{{ route('password.request') }}">
                                                {{ __('Esqueceu a senha?') }}
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
    </div>

@endsection
