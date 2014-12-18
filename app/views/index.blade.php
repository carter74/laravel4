@extends('layouts.default')

@section('content')

<p><h2><font color=grey>Jobs list:</font></h2></p>

{{ Form::open(array('name' => 'search', 'url' => 'search', 'method' => 'post')) }}
{{ Form::text('query'); }}
{{ Form::select('field', array('title' => 'Title', 'orgname' => 'Organization')); }}
{{ Form::submit('Search'); }}
{{ Form::close() }}

@if($jobs->count())
<ul>
    @foreach($jobs as $job)

<li><font class=bigfont><b>{{ $job->title }}</b></font> ({{ $job->created_at->format('d.m.Y H:i:s') }})<br>
{{ Str::limit($job->description, 50) }}<br>
<a href='{{ URL::action('get-job', $job->id) }}'>more info &raquo;</a><br><br>

    @endforeach
</ul>
@endif

<p><div style="background:#cccccc;padding:5px;"><b>New vacancy record:</b></div>

@if ($errors->has())
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}
	@endforeach
    </ul>
@endif

{{ Form::open(array('name' => 'applyjob', 'url' => 'applyjob', 'method' => 'post')) }}

<table style="background:#eeeeee;">
<tr><td>Title:</td>         <td>{{ Form::text('title'); }}</td></tr>
<tr><td>Organization:</td>  <td>{{ Form::text('orgname'); }}</td></tr>
<tr><td>e-mail:</td>        <td>{{ Form::text('email'); }}</td></tr>
<tr><td>Solary:</td>        <td>{{ Form::text('salary'); }}</td></tr>
<tr><td>Description:</td>   <td>{{ Form::text('description'); }}</td></tr></table>

{{ Form::submit('Apply'); }}
{{ Form::close() }}

</p>

<hr><p><h2><font color=grey>Applications list:</font></h2></p>


@if($appls->count())
<ul>
    @foreach($appls as $appl)

<li><font class=bigfont><b>{{ $appl->firstlastname }}</b></font> ({{ $appl->created_at->format('d.m.Y H:i:s') }})<br>
{{ Str::limit($appl->experience, 50) }}<br>
<a href='{{ URL::action('get-appl', $appl->id) }}'>more info &raquo;</a><br><br>

    @endforeach
</ul>
@endif

<p><div style="background:#cccccc;padding:5px;"><b>New application record:</b></div>

@if ($errors->has())
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}
	@endforeach
    </ul>
@endif

{{ Form::open(array('name' => 'applyappl', 'url' => 'applyappl', 'method' => 'post')) }}

<table style="background:#eeeeee;">
<tr><td>First and Last name:</td>   <td>{{ Form::text('firstlastname'); }}</td></tr>
<tr><td>e-mail:</td>                <td>{{ Form::text('email'); }}</td></tr>
<tr><td>Notice:</td>                <td>{{ Form::text('notice'); }}</td></tr>
<tr><td>Education:</td>             <td>{{ Form::text('education'); }}</td></tr>
<tr><td>Experience:</td>            <td>{{ Form::text('experience'); }}</td></tr></table>

{{ Form::submit('Apply'); }}
{{ Form::close() }}

</p>

@stop