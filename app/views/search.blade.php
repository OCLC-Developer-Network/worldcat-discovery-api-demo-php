@extends('layouts.master')

@section('content')
    <div class="span-24" id="header">
        <div style="margin: 10px 10px; font-size: 2em;">My Library</div>
    </div>    
    <div id="search-wrapper" class="span-24">
        {{ Form::open(array('url' => 'search', 'id' => 'search-form')) }}
        {{ Form::label('q', 'Catalog', array('style' => 'font-size: 2em; margin-right:1em;'))}}
        {{ Form::text('q', null, array('size' => 40))}}
        {{ Form::submit('Search')}}
        {{ Form::close() }}
    </div>
    <div class="span-24" id="footer">
        <p>&nbsp;</p>
    </div>
@stop
