@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-edit"></i> Alterar meus dados
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('home') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                    </div>
                </div>
            </div>


            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <p><strong>Whoops!</strong> Temos alguns problemas.</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['userslogged.update', $user->id]]) !!}
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                Nome
                                {!! Form::text('name', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                E-mail
                                {!! Form::text('email', null, ['placeholder' => '', 'class' => 'form-control', 'readonly'])!!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                CPF
                                {!! Form::text('cpf', null, ['placeholder' => '', 'class' => 'form-control', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                Telefone
                                {!! Form::text('phone', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>                


                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                Senha
                                {!! Form::password('password', ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                Confirmar Senha<
                                {!! Form::password('confirm-password', ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>                  


                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                    class="fas fa-save"></i> Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>   

                
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
