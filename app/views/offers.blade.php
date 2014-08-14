<div id="offers" class="span-6 last">
@if ($offers || getFulltextLink($record))
    <h2>Holdings</h2>
    <ul>
    @foreach ($offers as $offer)
        <li>{{$offer->getSeller()->getName()}} - {{$offer->getItemOffered()->getCollection()->getManagedBy()->getName()}}</li>
    @endforeach
    @if (getFulltextLink($record))
        <li><a href=">{{getFulltextLink($record)}}">Get Electronic Copy</a></li>
    @endif
    </ul>
@endif
</div>