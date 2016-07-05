@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Propiedades</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($propiedades, ['route' => ['propiedades.update', $propiedades->id], 'method' => 'patch']) !!}

            @include('propiedades.fields')

            {!! Form::close() !!}
        </div>
@endsection