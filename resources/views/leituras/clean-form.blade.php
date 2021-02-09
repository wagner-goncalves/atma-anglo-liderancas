<div class="panel panel-default">

    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">Create New Leitura</h4>
        </span>

        <div class="btn-group btn-group-sm pull-right" role="group">
            <a href="{{ route('leituras.leitura.index') }}" class="btn btn-primary" title="Show All Leitura">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
            </a>
        </div>

    </div>

    <div class="panel-body">

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('leituras.leitura.store', ['evento_id' => $evento_id]) }}" accept-charset="UTF-8"
            id="create_leitura_form" name="create_leitura_form" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('leituras.form', [
            'leitura' => null,
            ])

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input id="bt-save" class="btn btn-primary" type="submit" value="Add">
                </div>
            </div>

        </form>

    </div>
</div>
