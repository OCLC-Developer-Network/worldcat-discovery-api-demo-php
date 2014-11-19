<div id="more-info" class="span-10 last">
    @if (Config::get('app.showDbpediaInfo') && $dbpediaURI)
        <h2 id="{{$dbpediaURI}}">More Author Info</h2>
    @endif
    
    @if (Config::get('app.showDbpediaInfo') && count($identityKnows) > 0)
        <h3>Related Identities</h3>
        <ul>
            @foreach ($identityKnows as $identityKnown)
            <li>{{$identityKnown->get('schema:name')}}</li>
            @endforeach
        </ul>
    @endif

</div>
