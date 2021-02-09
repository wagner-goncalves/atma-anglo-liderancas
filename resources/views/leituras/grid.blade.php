<!-- Header -->
@php

@endphp

@if(!isset($evento))
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left pb-3">
            <div class="titulo-destaque">
                <i class="fas fa-chalkboard-teacher"></i> Gerenciar leituras
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="form-group">
                    {!! Form::open(['route' => 'leituras.leitura.exportar', 'method' => 'post', 'id' => 'form-exportar']) !!}
                    <script>
                        $(document).ready(function() {
                            $('#form-exportar').on('submit', function(e) {
                                var filter = $("#filter_leituras").val();
                                //var plano = parseInt($("#plano_id").val());
                                $("#filter_leituras_exportar").val(filter);
                                //$("#plano_id_exportar").val(plano);
                                return;
                            });
                        });
                    </script>      
                                      
                    <a href="{{ route('leituras.leitura.create', ['evento_id' => isset($evento) ? $evento->id : ""]) }}" class="btn btn-success"><i class="fas fa-plus"></i> Leitura</a>
                    {!! Form::hidden('filter_leituras', null, ['id' => 'filter_leituras_exportar']) !!}
                    <button id="btn-exportar" type="submit" class="btn btn-primary"><i class="fas fa-file-excel fa-lg"></i></button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @if(!isset($evento))
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <form method="GET" action="{{ \Request::getRequestUri() }}">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="questionario_id" class="small"><strong>Palavra-chave</strong></label>
                            <input type="text" class="form-control form-control-sm" id="filter_leituras" name="filter_leituras"
                                placeholder="Palavra-chave" value="{{ isset($filter_leituras) ? $filter_leituras : "" }}">
                        </div>
                        <div class="form-group col">
                            <label for="questionario_id" class="small"><strong>&nbsp;</strong></label>
                            <div>
                                <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                &nbsp;<a href="{{ route('leituras.leitura.index') }}"
                                    class="btn btn-sm btn-link mb-2">limpar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-exclamation-circle fa-lg"></i> {!! session('success_message') !!}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>@sortablelink('nome', 'Nome')</th>
                    <th>Ordem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @forelse ($leituras as $leitura)
                <tr>
                    <td>{{ $leitura->nome }}</td>
                    <td>{{ $leitura->ordem }}</td>
                    <td nowrap>

                        <a class="btn btn-sm btn-primary" href="{{ route('leituras.leitura.edit', ['leitura' => $leitura->id, 'page_leituras' => app('request')->input('page_leituras'), 'evento_id' => isset($evento) ? $evento->id : ""]) }}"><i class="fas fa-edit"></i></a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['leituras.leitura.destroy', $leitura->id], 'style' => 'display:inline']) !!}
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        @if(isset($evento))
                            {{ Form::hidden('evento_id', $evento->id) }}
                            {{ Form::hidden('page_leituras', app('request')->input('page_leituras')) }}
                            {{ Form::hidden('mestre', "eventos.evento.edit") }}
                        @endif
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
        {!! $leituras->appends(request()->query())->links() !!}
    </div>
</div>