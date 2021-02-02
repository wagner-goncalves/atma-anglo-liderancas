@extends('layouts.home')
@inject('Str', 'Illuminate\Support\Str')

@section('content')

    <div class="mb-4">
        <img class="img-fluid" style="width:100%" src="{{ asset('images/banner-curso.png') }}" />
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                Esta é a home.
            </div>
        </div>
    </div>
@endsection
