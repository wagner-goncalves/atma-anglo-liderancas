
<div class="form-group {{ $errors->has('evento_id') ? 'has-error' : '' }}">
    <label for="evento_id" class="col-md-2 control-label">Evento</label>
    <div class="col-md-10">
        <select class="form-control" id="evento_id" name="evento_id">
        	    <option value="" style="display: none;" {{ old('evento_id', optional($leitura)->evento_id ?: '') == '' ? 'selected' : '' }} disabled selected>Escolha...</option>
        	@foreach ($eventos as $key => $evento)
			    <option value="{{ $key }}" {{ old('evento_id', optional($leitura)->evento_id) == $key ? 'selected' : '' }}>
			    	{{ $evento }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('evento_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <label for="nome" class="col-md-2 control-label">Nome</label>
    <div class="col-md-10">
        <input class="form-control" name="nome" type="text" id="nome" value="{{ old('nome', optional($leitura)->nome) }}" minlength="1" maxlength="255">
        {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('descricao') ? 'has-error' : '' }}">
    <label for="descricao" class="col-md-2 control-label">Descricao</label>
    <div class="col-md-10">
        <textarea class="form-control" name="descricao" cols="50" rows="10" id="descricao" minlength="1" maxlength="1000">{{ old('descricao', optional($leitura)->descricao) }}</textarea>
        {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('arquivo') ? 'has-error' : '' }}">
    <label for="arquivo" class="col-md-2 control-label">Arquivo</label>
    <div class="col-md-10">
        <div class="input-group uploaded-file-group">
            <label class="input-group-btn">
                <span class="btn btn-default">
                    Browse <input type="file" name="arquivo" id="arquivo" class="hidden">
                </span>
            </label>
            <input type="text" class="form-control uploaded-file-name" readonly>
        </div>

        @if (isset($leitura->arquivo) && !empty($leitura->arquivo))
            <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_arquivo" class="custom-delete-file" value="1" {{ old('custom_delete_arquivo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                <span class="input-group-addon custom-delete-file-name">
                    {{ $leitura->arquivo }}
                </span>
            </div>
        @endif
        {!! $errors->first('arquivo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ordem') ? 'has-error' : '' }}">
    <label for="ordem" class="col-md-2 control-label">Ordem</label>
    <div class="col-md-10">
        <input class="form-control" name="ordem" type="number" id="ordem" value="{{ old('ordem', optional($leitura)->ordem) }}">
        {!! $errors->first('ordem', '<p class="help-block">:message</p>') !!}
    </div>
</div>

