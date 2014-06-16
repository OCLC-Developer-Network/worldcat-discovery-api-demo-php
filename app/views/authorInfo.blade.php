<div>
    @if ($dbpediaPerson->getBirthDate())
    <p>Birth Date: {{$dbpediaPerson->getBirthDate()}}</p>
    @endif
    
    @if ($dbpediaPerson->getDeathDate())
    <p>Death Date: {{$dbpediaPerson->getDeathDate()}}</p>
    @endif
    
    @if ($dbpediaPerson->getBirthPlace())
    <p>Birth Place: {{$dbpediaPerson->getBirthPlace()}}</p>
    @endif
    
    @if ($dbpediaPerson->getBio())
    <p>Biography: {{$dbpediaPerson->getBio()}}</p>
    @endif
    
    @if ($dbpediaPerson->getInfluences())
    <p>Influences: </p>
    <ul>
    @foreach ($dbpediaPerson->getInfluences() as $influence)
    <li>{{$influence->get('foaf:name')}}</li>
    @endforeach
    </ul>
    @endif
    
    @if ($dbpediaPerson->getOtherPublications())
    <p>Other Works: </p>
    <ul>
    @foreach ($dbpediaPerson->getOtherPublications() as $publication)
    <li><a href="{{$publication->get('foaf:isPrimaryTopicOf')}}">{{$publication->get('foaf:name')}}</a></li>
    @endforeach
    </ul>
    @endif
</div>
