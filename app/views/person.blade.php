@extends('layouts.master')

@section('content')
<div id="person-resource" class="span24 last">
    <div id="person-resource" resource="{{$person->getId()}}" typeof="{{$person->type()}}" class="span-18">
    <h1 id="person-resource-name" property="schema:name">{{$person->getName()}}</h1>
        
        <h3>Biographic Information</h3>
        <div>
        @if ($person->getBirthDate())
        <p>Birth Date: {{$person->getBirthDate()}}</p>
        @endif
        @if ($person->getDeathDate())
        <p>Death Date: {{$person->getDeathDate()}}</p>
        @endif
        @if ($dbpediaInfo->getBirthPlace())
        <p>Birth Place: {{$dbpediaPerson->getBirthPlace()}}</p>
        @endif
        @if ($dbpediaInfo->getDescription())
        <p>Biography: {{$dbpediaPerson->getDescription()}}</p>
        @endif
        
        @if ($person->getCreativeWorks() || $dbpediaInfo->getOtherPublications())
        <h3>Other Work</h3>
        @foreach ($person->getCreativeWorks() as $work)
        <p>{{$work->getName()}}</p>
        @endforeach

        @foreach ($dbpediaInfo->getOtherPublications() as $publication)
            <h5 class="more-section-heading">{{$publication->get('foaf:name')}}</h5>
            <p class="more-section-description">{{link_to($publication->get('foaf:isPrimaryTopicOf'))}}</p>
            <p></p>
            <p></p>
        @endforeach

        @endif
        
        @if ($dbpediaInfo->getInfluences() || $dbpediaInfo->getInfluenced())
            <h3>Intellectual Network</h3>
            <div>
                @if ($dbpediaInfo->getInfluences())
                <h5>Influenced By: </h5>
                <ul>
                @foreach ($dbpediaInfo->getInfluences() as $influence)
                <li>{{$influence->label('en')}}</li>
                @endforeach
                </ul>
                @endif
                
                @if ($dbpediaInfo->getInfluenced())
                <h5>Influenced: </h5>
                <ul>
                @foreach ($dbpediaInfo->getInfluenced() as $influenced)
                <li>{{$influenced->label('en')}}</li>
                @endforeach
                </ul>
                @endif
            </div>
        @endif
          
    </div>
</div> 
@stop