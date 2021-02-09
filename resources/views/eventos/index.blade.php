@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-chalkboard-teacher"></i> Gerenciar eventos
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::open(['route' => 'eventos.evento.exportar', 'method' => 'post', 'id' => 'form-exportar']) !!}
                            <script>
                                $(document).ready(function() {
                                    $('#form-exportar').on('submit', function(e) {
                                        var filter = $("#filter_eventos").val();
                                        //var plano = parseInt($("#plano_id").val());
                                        $("#filter_eventos_exportar").val(filter);
                                        //$("#plano_id_exportar").val(plano);
                                        return;
                                    });
                                });
        
                            </script>                        
                            <a href="{{ route('eventos.evento.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Evento</a> 
                            {!! Form::hidden('filter_eventos', null, ['id' => 'filter_eventos_exportar']) !!}
                            <button id="btn-exportar" type="submit" class="btn btn-primary"><i class="fas fa-file-excel fa-lg"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">

                    <form method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter_eventos" name="filter_eventos"
                                    placeholder="Palavra-chave" value="{{ $filter_eventos }}">
                            </div>
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('eventos.evento.index') }}"
                                        class="btn btn-sm btn-link mb-2">limpar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($message = Session::get('success_message'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {!! $message !!}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {!! $message !!}
                </div>
            @endif              

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@sortablelink('nome', 'Nome')</th>
                        <th>Data Inicio</th>
                        <th>Data Fim</th>
                        <th>Link</th>
                        <th>Ativo?</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                @forelse ($eventos as $evento)
                    <tr>
                        <td>{{ $evento->nome }}</td>
                        <td>{{ $evento->data_inicio }}</td>
                        <td>{{ $evento->data_fim }}</td>
                        <td>{{ $evento->link }}</td>
                        <td>{{ $evento->is_active ? 'Sim' : 'Não' }}</td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('eventos.evento.edit', ['evento' => $evento->id, 'page_eventos' => app('request')->input('page_eventos')]) }}"><i class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['eventos.evento.destroy', $evento->id], 'style' => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            {{ Form::hidden('page_eventos', app('request')->input('page_eventos')) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><i class="fas fa-frown"></i> Nenhum registro encontrado.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            {!! $eventos->appends(request()->query())->links() !!}
        </div>
    </div>


@endsection
