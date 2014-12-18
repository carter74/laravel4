@extends('layouts.default')

@section('content')

@if ($errors->has())

    @foreach ($errors->all() as $error)
        <p><h2>{{ $error }}</h2></p>
	@endforeach

@endif

@stop