@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                @if(!isset($user->id) || intval($user->id) == 0)
                    <i class="fas fa-user"></i> Criar usuário
                @else
                    <i class="fas fa-edit"></i> Editar usuário
                @endif  
                    
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


            @if(!isset($user->id) || intval($user->id) == 0)
                {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit-form']) !!}
            @else
                {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['users.update', isset($user->id) ? $user->id : 0]]) !!}
            @endif            

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('name', $user->name, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>E-mail:</strong>
                                {!! Form::text('email', $user->email, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>Telefone:</strong>
                                {!! Form::text('phone', $user->phone, ['placeholder' => '', 'class' => 'form-control phone']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>Empresa:</strong>
                                <select id="empresa_id" name="empresa_id" class="form-control">
                                    <option value="">Escolha</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" {{ $user->empresa_id == $empresa->id ? 'selected' : '' }}>
                                            {{ $empresa->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>CPF:</strong>
                                {!! Form::text('cpf', $user->cpf, ['placeholder' => '', 'class' => 'form-control cpf']) !!}
                            </div>
                        </div>                        
                    </div>
                </div>

                @if(isset($user->id) && intval($user->id) > 0)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Senha:</strong>
                                {!! Form::password('password', ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Confirma senha:</strong>
                                {!! Form::password('confirm-password', ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <strong>Papéis:</strong>
                                {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                            class="fas fa-save"></i> Salvar</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <script>

        $(document).ready(function(){
            $("input.phone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {  
                var target, phone, element;  
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
                phone = target.value.replace(/\D/g, '');
                element = $(target);  
                element.unmask();  
                if(phone.length > 10) {  
                    element.mask("(99) 99999-999?9");  
                } else {  
                    element.mask("(99) 9999-9999?9");  
                }  
            });
            $("input.cpf").mask("999.999.999-99")
        });
    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
