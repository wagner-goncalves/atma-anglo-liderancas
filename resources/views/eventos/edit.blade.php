@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($evento->id) || intval($evento->id) == 0)
                        <i class="fas fa-plus"></i> Novo evento
                    @else
                        <i class="fas fa-edit"></i> Editar evento
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
                        <a href="{{ route('eventos.evento.index', ['page_eventos' => app('request')->input('page_eventos')]) }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($evento->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['eventos.evento.destroy', $evento->id],
                            'style' => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            {{ Form::hidden('page_eventos', app('request')->input('page_eventos')) }}
                            {!! Form::close() !!}
                        @endif
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

            @if (Session::has('success_message'))
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok"></span>
                    {!! session('success_message') !!}

                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            @endif

            <div id="tabs">
                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-evento-tab" data-toggle="pill" href="#pills-evento" role="tab"
                            aria-controls="pills-home" aria-selected="true">Sobre o Evento</a>
                    </li>
                    @if (intval($evento->id) > 0)
                    <li class="nav-item">
                        <a class="nav-link" id="pills-leitura-tab" data-toggle="pill" href="#pills-leitura" role="tab"
                            aria-controls="pills-profile" aria-selected="false"
                            data-url="{{ route('leituras.leitura.index', ['evento_id' => $evento->id]) }}">Leituras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-video-tab" data-toggle="pill" href="#pills-video" role="tab"
                            aria-controls="pills-contact" aria-selected="false" data-url="?action=images">Vídeos</a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-evento" role="tabpanel" aria-labelledby="pills-evento-tab">

                    @if (!isset($evento->id) || intval($evento->id) == 0)
                        {!! Form::open(['route' => 'eventos.evento.store', 'method' => 'POST', 'enctype' =>
                        'multipart/form-data', 'id' => 'edit-form']) !!}
                    @else
                        {!! Form::model($evento, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' =>
                        'edit-form', 'route' => ['eventos.evento.update', isset($evento->id) ? $evento->id : 0]]) !!}
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('nome', $evento->nome, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Descrição:</strong>
                                {!! Form::textarea('descricao', $evento->descricao, ['placeholder' => '', 'class' =>
                                'form-control', 'id' => 'descricao']) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Data início:</strong>
                                <div class="input-group mb-3" id="picker-data_inicio">
                                    {!! Form::text('data_inicio', $evento->data_inicio, [
                                    'placeholder' => '',
                                    'class' => 'form-control data_inicio',
                                    ]) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2"><span
                                                class="fa fa-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <strong>Data fim:</strong>
                            <div class="input-group mb-3" id="picker-data_fim">
                                {!! Form::text('data_fim', $evento->data_fim, [
                                'placeholder' => '',
                                'class' => 'form-control data_fim',
                                ]) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><span
                                            class="fa fa-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Link:</strong>
                                {!! Form::text('link', $evento->link, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Arquivo:</strong>
                                <div>
                                    {!! Form::file('imagem', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="mt-2">
                                    @if (!empty($evento->imagem))
                                        <a class="btn btn-secondary btn-sm"
                                            href="{{ route('eventos.evento.download', ['evento' => $evento->id]) }}"><i
                                                class="fas fa-download"></i> Download</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Ativo:</strong>
                                <div class="checkbox">
                                    <label for="is_active_1">
                                        <input id="is_active_1" class="" name="is_active" type="checkbox" value="1"
                                            {{ old('is_active', optional($evento)->is_active) == '1' ? 'checked' : '' }}>
                                        Sim
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="save" value="ok"
                                class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                    class="fas fa-save"></i> Salvar</button>

                            <button name="save-continue" value="ok" type="submit"
                            class="btn pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-save"></i> Salvar e Continuar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if (intval($evento->id) > 0)
                <div class="tab-pane fade" id="pills-leitura" role="tabpanel" aria-labelledby="pills-leitura-tab">
                    @include("leituras.grid", ["evento" => $evento])
                </div>
                <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">

                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <link rel="stylesheet"
        href="{{ asset('node_modules/pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
    <script>
        //Máscaras dos inputs
        $(document).ready(function() {
            $("input.data_inicio").mask("99/99/9999");
            $("input.data_fim").mask("99/99/9999");
            $('#picker-data_inicio, #picker-data_fim').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });

    </script>

    <script>
        //Gerencia tabs
        $(document).ready(function() {
            {!! is_numeric(app('request')->input('leitura_id')) || is_numeric(app('request')->input('page_leituras')) ? "$('#pills-leitura-tab').tab('show')" : '' !!}
        });

    </script>

    <script src="{{ asset('node_modules/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#descricao',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'bold italic | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat'
        });

    </script>

@endsection
