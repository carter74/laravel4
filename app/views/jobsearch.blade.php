@extends('layouts.default')

@section('content')

{{ Form::open(array('name' => 'search', 'url' => 'search', 'method' => 'post')) }}
<input name="query" type="text" value="{{ $query }}">
{{ Form::select('field', array('title' => 'Title', 'orgname' => 'Organization')); }}
{{ Form::submit('Search'); }}
{{ Form::close() }}

<p><h2><font color=grey>Jobs search:</font></h2></p>

<b>query:</b> {{ $query }} <b>in</b> <?php switch ($field) { case 'title': echo "Title"; break; case 'orgname': echo "Organization"; break;} ?>

<ul>
@foreach($results as $rslt)

<li><font class=bigfont><b>{{ $rslt->title }}</b></font><br>
{{ $rslt->orgname }}<br>
{{ Str::limit($rslt->description, 50) }}<br>
<a href='{{ URL::action('get-job', $rslt->id) }}'>more info &raquo;</a><br><br>

@endforeach
</ul>

@stop