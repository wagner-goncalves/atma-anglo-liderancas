@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($leitura->nome) ? $leitura->nome : 'Leitura' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('leituras.leitura.destroy', $leitura->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('leituras.leitura.index') }}" class="btn btn-primary" title="Show All Leitura">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('leituras.leitura.create') }}" class="btn btn-success" title="Create New Leitura">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('leituras.leitura.edit', $leitura->id ) }}" class="btn btn-primary" title="Edit Leitura">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Leitura" onclick="return confirm(&quot;Click Ok to delete Leitura.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Evento</dt>
            <dd>{{ optional($leitura->evento)->nome }}</dd>
            <dt>Nome</dt>
            <dd>{{ $leitura->nome }}</dd>
            <dt>Descricao</dt>
            <dd>{{ $leitura->descricao }}</dd>
            <dt>Arquivo</dt>
            <dd>{{ asset('storage/' . $leitura->arquivo) }}</dd>
            <dt>Created At</dt>
            <dd>{{ $leitura->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $leitura->updated_at }}</dd>
            <dt>Ordem</dt>
            <dd>{{ $leitura->ordem }}</dd>

        </dl>

    </div>
</div>

@endsection