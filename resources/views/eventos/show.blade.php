@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($evento->nome) ? $evento->nome : 'Evento' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('eventos.evento.destroy', $evento->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('eventos.evento.index') }}" class="btn btn-primary" title="Show All Evento">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('eventos.evento.create') }}" class="btn btn-success" title="Create New Evento">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('eventos.evento.edit', $evento->id ) }}" class="btn btn-primary" title="Edit Evento">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Evento" onclick="return confirm(&quot;Click Ok to delete Evento.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Nome</dt>
            <dd>{{ $evento->nome }}</dd>
            <dt>Descricao</dt>
            <dd>{{ $evento->descricao }}</dd>
            <dt>Data Inicio</dt>
            <dd>{{ $evento->data_inicio }}</dd>
            <dt>Data Fim</dt>
            <dd>{{ $evento->data_fim }}</dd>
            <dt>Link</dt>
            <dd>{{ $evento->link }}</dd>
            <dt>Imagem</dt>
            <dd>{{ $evento->imagem }}</dd>
            <dt>Created At</dt>
            <dd>{{ $evento->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $evento->updated_at }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($evento->is_active) ? 'Sim' : 'Não' }}</dd>

        </dl>

    </div>
</div>

@endsection