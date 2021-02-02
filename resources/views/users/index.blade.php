@extends('layouts.app')


@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


    <div class="modal" tabindex="-1" role="dialog" id="modal-mensagem">
        <div class="modal-dialog" role="document">s
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atenção!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="mensagem_modal"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-users"></i> Gerenciar usuários do sistema
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                            Usuário</a>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ \Request::getRequestUri() }}" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="empresa_id" class="small"><strong>Empresa</strong></label>
                                <select id="empresa_id" name="empresa_id" class="form-control form-control-sm">
                                    <option value="">Todas</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}"
                                            {{ $empresa_id == $empresa->id ? 'selected' : '' }}>
                                            {{ $empresa->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="filter" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                    placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('matriculas.index') }}"
                                        class="btn btn-sm btn-link mb-2">limpar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
                </div>
            @endif
            
            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {!! $message !!}
                </div>
            @endif       

            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>@sortablelink('name', 'Nome')</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Papéis</th>
                    <th>Ações</th>
                </tr>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->cpf }}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('users.edit', $user->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' =>
                            'display:inline', 'class' => 'form-delete-' . $user->id]) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            <script>
                                $(document).ready(function() {
                                    var confirmed = false;
                                    $('.form-delete-{{$user->id}}').on("submit", function(e){
                                        if(!confirmed){
                                            e.preventDefault();
                                            $.confirm({
                                                title: 'Apagar usuário.',
                                                content: 'Ao deletar este usuário, você também deletará as interações deste usuário com o curso. Confirmar exclusão?',
                                                buttons: {
                                                    No: {
                                                        text: 'Não', // With spaces and symbols
                                                        action: function () {
                                                            return;
                                                        }
                                                    },
                                                    Yes: {
                                                        text: 'Sim', // With spaces and symbols
                                                        btnClass: 'btn-red',
                                                        action: function () {
                                                            confirmed = true;
                                                            $('.form-delete-{{$user->id}}').submit();
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    });
                                    /*
                                    $('.form-delete-{{$user->id}}').on('submit', function(e) {
                                        e.preventDefault();
                                        if (confirm("Ao deletar este usuário você também deletará as interações deste usuário com o curso. Confirmar exclusão?")){
                                            $(this).submit();
                                            return true;
                                        }
                                        return false;
                                    });
                                    */
                                });
                        
                            </script>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>


        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            {!! $users->appends(request()->query())->links() !!}
        </div>
    </div>

@endsection
