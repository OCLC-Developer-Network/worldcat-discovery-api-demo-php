@extends('layouts.master')

@section('content')
<div id="bibliographic-resource" resource="{{$record->getId()}}" typeof="{{$record->getType()}}">
    <h1 id="bibliographic-resource-name" property="schema:name">{{$record->getName()}}</h1>
    
    @if ($record->getAuthor())
    <div id="author" property="schema:author" resource="{{$record->getAuthor()->getUri()}}" typeof="{{$record->getAuthor()->type()}}">
        <h2 id="author-name" property="schema:name">{{$record->getAuthor()->getName()}}</h2>
    </div>
    @endif
    
    @if (count($record->getContributors()) > 0)
    <h3>Contributors</h3>
    <ul>
        @foreach ($record->getContributors() as $contributor)
        <li property="schema:contributor" resource="{{$contributor->getUri()}}" typeof="{{$contributor->type()}}"><span class="constributor-name" property="schema:name">{{$contributor->getName()}}</span></li>
        @endforeach
    </ul>
    @endif
    
    @if (count($record->getAbout()) > 0)
    <h2>Subjects</h2>
    <ul>
        @foreach (getDisplaySubjects($record->getAbout()) as $about)
        <li property="schema:about" resource="{{$about->getUri()}}" typeof="{{$about->type()}}"><span class="subject-name" property="schema:name">{{$about->getName()}}</span></li>
        @endforeach
    </ul>
    @endif
    
    <h2>Publication Info</h2>
    <p>
    @if ($record->getType())
    <span class="label">Format: </span><span class="value">{{getFormatString($record->getType())}}</span>
    <br/>
    @endif
    
    @if ($record->getLanguage())
    <span class="label">Language: </span><span class="value" property="schema:inLanguage">{{getLanguageString($record->getLanguage())}}</span>
    <br/>
    @endif

    <span class="label">Published: </span>
    <span class="value" property="schema:datePublished">{{$record->getDatePublished()}}</span>
    <br/>
    
    @if ($record->getIsPartOf())
    <span property="schema:isPartOf" resource="{{$record->getIsPartOf()->getUri()}}">
        <span property="schema:isPartOf" resource="{{$record->getIsPartOf()->getVolume()->getUri()}}">
            <span property="schema:isPartOf" resource="{{$record->getIsPartOf()->getVolume()->getPeriodical()->getUri()}}">
                <span class="label">Title: </span>
                <span property="schema:name">{{$record->getIsPartOf()->getVolume()->getPeriodical()->getName()}}</span>
            </span>
            <span class="label">Volume: </span>
            <span property="schema:volumeNumber">
                {{$record->getIsPartOf()->getVolume()->getVolumeNumber()}}
            </span>
        </span>
        <span class="label">Issue: </span>
        <span property="schema:issueNumber">
            {{$record->getIsPartOf()->getIssueNumber()}}
        </span>
    </span>
    <br/>
    @endif
    
    @if ($record->getPageStart())
    <span class="label">Pages: </span>
    <span class="value"><span property="schema:pageStart">{{$record->getPageStart()}}</span> - <span property="schema:pageEnd">{{$record->getPageEnd()}}</span></span>
    <br/>
    @endif
        
    <span class="label">OCLC Number:</span>
    <span class="value" property="http://purl.org/library/oclcnum">{{$record->getOCLCNumber()}}</span>
    <br/>
    </p>
    
    @if ($record->getDescriptions())
    <h3>Description</h3>
    <p property="schema:description">{{getDescriptionString($record->getDescriptions())}}</p>
    @endif
    
</div>   
@stop