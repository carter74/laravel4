@extends('layouts.default')

@section('content')

<article>
<h2>{{ $appl->firstlastname }}</h2>
<p><b>Pub on:</b> {{  $appl->created_at->format('d.m.Y H:i:s') }}</p>
<p><b>e-mail:</b> {{ $appl->email }}</p>
<p><b>Notice:</b> {{ $appl->notice }}</p>
<p><b>Education:</b> {{ $appl->education }}</p>
<p><b>Experience:</b> {{ $appl->experience }}</p>
</article>

{{ Form::open() }}

<a href="/">back &laquo;</a>

@stop
