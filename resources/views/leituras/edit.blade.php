@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($leitura->id) || intval($leitura->id) == 0)
                        <i class="fas fa-plus"></i> Nova leitura
                    @else
                        <i class="fas fa-edit"></i> Editar leitura
                    @endif

                    @if (!empty($evento))
                        do evento {{ $evento->nome }}
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
                        @php
                            $voltar = !empty($evento) ?  route('eventos.evento.edit', ['evento' => $evento->id, 'leitura_id' => intval($leitura->id), 'page_leituras' => app('request')->input('page_leituras')]) : route('leituras.leitura.index');
                            if(!empty($evento) && intval($leitura->id) > 0) $voltar = route('eventos.evento.edit', ['evento' => $evento->id, 'leitura_id' => $leitura->id, 'page_leituras' => app('request')->input('page_leituras')]);
                        @endphp
                        

                        <a href="{{ $voltar }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($leitura->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['leituras.leitura.destroy', $leitura->id], 'style' => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            @if(isset($evento))
                                {{ Form::hidden('evento_id', $evento->id) }}
                                {{ Form::hidden('page_leituras', app('request')->input('page_leituras')) }}
                                {{ Form::hidden('mestre', "eventos.evento.edit") }}
                            @endif                            
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

            <div class="tab-pane fade show active" id="pills-leitura" role="tabpanel" aria-labelledby="pills-leitura-tab">

                @if (!isset($leitura->id) || intval($leitura->id) == 0)
                    {!! Form::open(['route' => 'leituras.leitura.store', 'method' => 'POST', 'enctype' =>
                    'multipart/form-data', 'id' => 'edit-form']) !!}
                @else
                    {!! Form::model($leitura, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                    'route' => ['leituras.leitura.update', isset($leitura->id) ? $leitura->id : 0]]) !!}
                @endif
                @csrf
                <div class="row">
                    @if (!empty($evento))
                        {{ Form::hidden('evento_id', $evento->id) }}
                        {{ Form::hidden('page_leituras', app('request')->input('page_leituras')) }}
                        {{ Form::hidden('mestre', "eventos.evento.edit") }}
                    @else
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Evento</strong>
                                <select id="evento_id" name="evento_id" class="form-control">
                                    <option value="">Escolha</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->id }}"
                                            {{ $leitura->evento_id == $evento->id ? 'selected' : '' }}>
                                            {{ $evento->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nome:</strong>
                            {!! Form::text('nome', $leitura->nome, ['placeholder' => '', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descrição:</strong>
                            {!! Form::textarea('descricao', $leitura->descricao, ['placeholder' => '', 'class' =>
                            'form-control', 'id' => 'descricao']) !!}
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Ordem:</strong>
                            {!! Form::input('number', 'ordem', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Arquivo:</strong>
                            <div>
                                {!! Form::file('arquivo', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="mt-2">
                                @if (!empty($leitura->arquivo))
                                    <a class="btn btn-secondary btn-sm"
                                        href="{{ route('leituras.leitura.download', ['leitura' => $leitura->id]) }}"><i
                                            class="fas fa-download"></i> Download</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group row">
                    <button type="submit" name="save" value="ok"
                    class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                        class="fas fa-save"></i> Salvar</button>

                    <button name="save-continue" value="ok" type="submit"
                    class="btn pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                        class="fas fa-save"></i> Salvar e Continuar</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <script>
        /*
            //Tratamento de tabs remoras
            $(document).ready(function() {
                //the reason for the odd-looking selector is to listen for the click event
                // on links that don't even exist yet - i.e. are loaded from the server.
                $('#tabs').on('click', '.tablink,#pills-tab a', function(e) {
                    e.preventDefault();
                    var url = $(this).attr("data-url");

                    if (typeof url !== "undefined") {
                        var pane = $(this),
                            href = this.hash;

                        // ajax load from data-url
                        $(href).load(url, function(result) {
                            pane.tab('show');
                            bindButtons(href, pane);
                        });

                    } else {
                        $(this).tab('show');
                    }
                });

                function bindButtons(href, pane) {
                    var btcreate = $('#bt-create');
                    if (typeof btcreate !== "undefined") {
                        btcreate.on('click', function(ev) {
                            ev.preventDefault();
                            var urlcreate = $(this).attr("href");
                            $(href).load(urlcreate + '?leitura_id={{ $leitura->id }}', function(result) {
                                pane.tab('show');
                            });
                        });
                    }
                }

            });
            */

    </script>

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
