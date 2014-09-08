@extends('layouts.master')

@section('content')
<div id="bibliographic-resource" class="span24" style="margin-top: 2em">
@if (is_a($record, 'WorldCat\Discovery\Article'))
    @include('article', array('record', $record))
@else    
    @include('work', array('record', $record))
@endif
@include('offers', array('offers'=> $offers, 'record' => $record))
</div>   
@stop