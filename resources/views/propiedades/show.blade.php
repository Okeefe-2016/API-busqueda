@extends('layouts.app')

@section('content')
    @include('propiedades.show_fields')

    <div class="form-group">
           <a href="{!! route('propiedades.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
