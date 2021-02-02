@extends('layouts.app')


@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-user"></i> Criar novo usuario
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('users.index') }}"
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



            {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}


            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                    {!! Form::text('name', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    {!! Form::text('email', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Telefone</label>
                <div class="col-sm-10">
                    {!! Form::text('phone', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Senha</label>
                <div class="col-sm-10">
                    {!! Form::text('password', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
            </div>


            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Confirmar Senha</label>
                <div class="col-sm-10">
                    {!! Form::text('confirm-password', null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Papéis</label>
                <div class="col-sm-10">
                    {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit"
                        class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                            class="fas fa-save"></i> Salvar</button>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>





@endsection
