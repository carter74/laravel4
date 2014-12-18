@extends('layouts.default')

@section('content')

<article>
<h2>{{ $job->title }}</h2>
<p><b>Pub on: </b>{{  $job->created_at->format('d.m.Y H:i:s') }}</p>
<p><b>Organization name:</b> {{ $job->orgname }}</p>
<p><b>e-mail:</b> {{ $job->email }}</p>
<p><b>Description:</b> {{ $job->description }}</p>
<p><b>Salary:</b> {{ $job->salary }}</p>
</article>

{{ Form::open() }}

<a href="/">back &laquo;</a>

@stop
