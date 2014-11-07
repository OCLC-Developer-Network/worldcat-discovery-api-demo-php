        @if (count($reccomendations) > 0)
        <div id="reccomendations">
        <h2>Reccomended Related Titles </h2>
        <ul>
        @foreach ($reccomendations as $reccomendation)
            <li>{{link_to_route('fullRecord', $reccomendation['title'], array($reccomendation['oclcNumber']))}}</li>
        @endforeach
        </ul>
        @endif