@extends('layouts.master')

@section('content')
<div id="bibliographic-resource" class="span24" style="margin-top: 2em">
    @if (is_a($record, 'WorldCat\Discovery\Article'))
        @include('article', array('record', $record))
    @else    
        @include('work', array('record', $record))
    @endif
    <div id="availability-and-more" class="span-10 last">
        @include('offers', array('offers'=> $offers, 'record' => $record))
        @include('moreInfo', array('dbpediaURI'=> $record->getAuthor()->getDbpediaUri()))
    </div>
</div>   
@stop