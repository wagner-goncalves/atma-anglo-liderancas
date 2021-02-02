@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
            <div>

                <div class="card-body">

                    <div class="card-title titulo-destaque"><i class="fas fa-envelope"></i>
                        {{ __('Verifique seu e-mail') }}
                    </div>
                    <hr />


                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('O link de redefinição de senha foi enviado para seu e-mail') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, por favor, verifique em seu e-mail o link de validação.') }}
                    {{ __('Se você não recebeu o e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase">{{ __('Clique aqui para enviar novamente.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
