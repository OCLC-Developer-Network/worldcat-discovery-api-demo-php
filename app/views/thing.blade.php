@extends('layouts.master')

@section('content')
<div id="thing-resource" class="span24 last">
    <div id="thing-resource" resource="{{$thing->getId()}}" typeof="{{$thing->getType()}}" class="span-18">
    <h1 id="thing-resource-name" property="schema:name">{{$thing->getName()}}</h1>
</div> 
@stop