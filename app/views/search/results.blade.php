@extends('layouts.master')

@section('content')
<div id="search-results" class="span24 last">
    <div id="facets" class="span-6">
    <h2>Facets</h2>
    @if ($facetQueries)
        <h3>Selected Facets</h3>
        <ul>
        @foreach ($facetQueries as $facet => $facetValue)
        <li>{{$facet}} {{link_to_route('searchResults', '[Remove]', array('q' => $query, 'facetQueries' => getFacetRefineQueryString($facet, $facetValue, $facetQueries, true), 'startNum' => $search->getStartIndex()))}}</li>
        @endforeach
        </ul>
    @endif
    @foreach ($search->getFacets() as $facet)
        <h3>{{camelCaseToTitle($facet->getFacetIndex())}}</h3>
        <ul class="facet-items">
        @foreach ($facet->getFacetValues() as $facetValue)
            <li>{{link_to_route('searchResults', getFacetDisplayName($facet, $facetValue), array('q' => $query, 'facetQueries' => getFacetRefineQueryString($facet->getFacetIndex(), $facetValue->getName(), $facetQueries), 'startNum' => $search->getStartIndex()))}}</li>
        @endforeach
        </ul>
    @endforeach
    </div>
    <div id="search-results" class="span-18 last" resource="{{$search->getUri()}}" typeof="{{$search->type()}}">
    <h2>Results</h2>
    <div class="search-page-navigation span18 last">
        <div class="previous span-6 first">
            @if (isset($pagination['previous_page_start']))
                {{link_to_route('searchResults', 'Previous', array('q' => $query, 'facetQueries' => getFacetQueryString($facetQueries), 'startNum' => $pagination['previous_page_start']))}}
            @else
                <span class="inactive-link">Previous</span>
            @endif
        </div>
        <div class="numbering span-6">
        #{{$pagination['first']}} - #{{$pagination['last']}} of #{{$pagination['total']}}
        </div>
        <div class="next span-6 last">
            @if (isset($pagination['next_page_start']))
                {{link_to_route('searchResults', 'Next', array('q' => $query, 'facetQueries' => getFacetQueryString($facetQueries), 'startNum' => $pagination['next_page_start']))}}
            @else
                <span class="inactive-link">Next</span>
            @endif
        </div>
    </div>
    <ol id="results-items" start="{{$search->getStartIndex()+1}}">
        @foreach ($search->getSearchResults() as $result)
            <li class="search-result" resource="{{$result->getId()}}" typeof="{{$result->getType()}}">
            <h3 class="title">
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
            </li>
        @endforeach
    </ol>
    </div>
</div>
@stop
