<div id="availability-and-more" class="span-10 last">
    <div id="availability" class="span-10">
    <h2>Availability</h2>
    @if ($offers || getFulltextLink($record))
        @foreach ($offers as $offer)
            <p>{{$offer->getSeller()->getName()}}</p>
        @endforeach
        @if (getFulltextLink($record))
            <p>{{link_to(getFulltextLink($record), 'Get Electronic Copy')}}</p>
        @endif
    @else
        <p>This item is not available at your library</p>
    @endif
    </div>
    <div id="more-info" class="span-10 last"/>
    
</div>