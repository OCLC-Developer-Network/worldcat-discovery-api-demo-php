<div id="offers" class="span-6 last">
@if ($offers || getFulltextLink($record))
    <h2>Holdings</h2>
    <ul>
    @foreach ($offers as $offer)
        <li>{{$offer->getSeller()->getName()}}}}</li>
    @endforeach
    @if (getFulltextLink($record))
        <li>{{link_to(getFulltextLink($record), 'Get Electronic Copy')}}</li>
    @endif
    </ul>
@endif
</div>