@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-key"></i> Reiniciar sua senha
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">

                        <a href="{{route('home')}}" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i class="fas fa-check"></i> ACESSAR CURSO</a>

                    </div>    
                </div>            
            @else
                <div class="alert alert-danger">
                    Este é o seu primeiro acesso. Para sua segurança, cadastre uma senha personalizada.
                    <br /><strong>Importante:</strong> o seu próximo acesso será realizado com a senha deste cadastro.

                </div>

                <form class="form-horizontal" method="POST" action="{{ route('password.post_expired') }}">
                    {{ csrf_field() }}
                    <div class="row">



                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label for="current_password" class="control-label">Senha atual</label>
                                    <input id="current_password" type="password" class="form-control"
                                        name="current_password" required="">

                                    @if ($errors->has('current_password'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('current_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-row">

                                <div class="form-group col-md-6{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Nova senha</label>
                                    <input id="password" type="password" class="form-control" name="password" required="">

                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div
                                    class="form-group col-md-6{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="control-label">Confirmar nova senha</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required="">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit"
                                        class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                            class="fas fa-save"></i> Reiniciar senha</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </form>


            @endif
        </div>
    </div>

@endsection
