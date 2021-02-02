
<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <label for="nome" class="col-md-2 control-label">Nome</label>
    <div class="col-md-10">
        <input class="form-control" name="nome" type="text" id="nome" value="{{ old('nome', optional($evento)->nome) }}" minlength="1" maxlength="255" required="true">
        {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('descricao') ? 'has-error' : '' }}">
    <label for="descricao" class="col-md-2 control-label">Descricao</label>
    <div class="col-md-10">
        <textarea class="form-control" name="descricao" cols="50" rows="10" id="descricao" minlength="1" maxlength="1000">{{ old('descricao', optional($evento)->descricao) }}</textarea>
        {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('data_inicio') ? 'has-error' : '' }}">
    <label for="data_inicio" class="col-md-2 control-label">Data Inicio</label>
    <div class="col-md-10">
        <input class="form-control" name="data_inicio" type="text" id="data_inicio" value="{{ old('data_inicio', optional($evento)->data_inicio) }}">
        {!! $errors->first('data_inicio', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('data_fim') ? 'has-error' : '' }}">
    <label for="data_fim" class="col-md-2 control-label">Data Fim</label>
    <div class="col-md-10">
        <input class="form-control" name="data_fim" type="text" id="data_fim" value="{{ old('data_fim', optional($evento)->data_fim) }}">
        {!! $errors->first('data_fim', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
    <label for="link" class="col-md-2 control-label">Link</label>
    <div class="col-md-10">
        <input class="form-control" name="link" type="text" id="link" value="{{ old('link', optional($evento)->link) }}" minlength="1">
        {!! $errors->first('link', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('imagem') ? 'has-error' : '' }}">
    <label for="imagem" class="col-md-2 control-label">Imagem</label>
    <div class="col-md-10">
        <input class="form-control" name="imagem" type="number" id="imagem" value="{{ old('imagem', optional($evento)->imagem) }}">
        {!! $errors->first('imagem', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">Is Active</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($evento)->is_active) == '1' ? 'checked' : '' }}>
                Sim
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

