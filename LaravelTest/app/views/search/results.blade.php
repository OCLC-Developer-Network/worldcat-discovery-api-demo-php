@extends('layouts.master')

@section('content')
<div id="search-results" resource="{{$search->getUri()}}" typeof="{{$search->type()}}">
<h2>Results</h2>
<p>Total Results - {{{$search->getTotalResults()}}}</p>
@foreach ($search->getSearchResults() as $result)
    <div class="search-result" resource="{{$result->getId()}}" typeof="{{$result->getType()}}">
    <h3 class="title">
        <span property="http://purl.org/goodrelations/v1#displayPosition">{{$result->getDisplayPosition()}}. </span>
        <span id="bibliographic-resource-name" property="schema:name">{{link_to_route('fullRecord', $result->getName(), array($result->getOCLCNumber()))}}</span>
        <span class="date-published" property="schema:datePublished">{{$result->getDatePublished()}}</span>
    </h3>
    @if ($result->getAuthor())
    <p class="author" property="schema:author" resource="{{$result->getAuthor()->getUri()}}" typeof="{{$result->getAuthor()->type()}}">
        <span property="schema:name">{{$result->getAuthor()->getName()}}</span>
    </p>
    @endif
    @if ($result->getType())
    <p class="format">
        <span class="label">Format:</span>
        <span class="value">{{getFormatString($result->getType())}}</span>
    </p>
    @endif
    </div>
@endforeach
</div>
@stop
