
    <div id="availability" class="span-10">
    <h2>Availability</h2>
    @if ($offers || (Config::get('app.showEHoldings') && getFulltextLink($record)))
        @foreach ($offers as $offer)
            <p>{{$offer->getSeller()->getName()}}</p>
            @if (Config::get('app.showAvailability') && getAvailability($record->getOCLCNumber(), $offer->getSeller()))
                <ul>
                @foreach(getAvailability($record->getOCLCNumber(), $offer->getSeller()) as $copy)
                    <li>{{$copy['branchLocation']}} {{$copy['shelvingLocation']}} {{$copy['callNumber']}} - {{$copy['available']}}</li>
                @endforeach
                </ul>
            @endif
        @endforeach
        @if (Config::get('app.showEHoldings') && getFulltextLink($record))
            <p>{{link_to(getFulltextLink($record), 'Get Electronic Copy')}}</p>
        @endif
    @else
        <p>This item is not available at your library</p>
    @endif
    </div>