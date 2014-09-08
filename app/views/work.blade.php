<div id="bibliographic-resource" resource="{{$record->getId()}}" typeof="{{$record->getType()}}">

    <div id="statement-of-responsibility" class="span-24">
        <h1 id="bibliographic-resource-name" property="schema:name">{{$record->getName()}}</h1>
        
        @if ($record->getAuthors())
            <h2 id="author-name">{{getAuthorString($record->getAuthors())}}</h2>
        @endif
    </div>
    
    <div class="span-13 append-1 first">
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
        
        @if ($record->getBookEdition())
        <span class="label">Edition: </span><span class="value" property="schema:bookEdition">{{$record->getBookEdition()}}</span>
        <br/>
        @endif
        
        @if ($record->getLanguage())
        <span class="label">Language: </span><span class="value" property="schema:inLanguage">{{getLanguageString($record->getLanguage())}}</span>
        <br/>
        @endif
        
        <span class="label">Published: </span>
        <span class="value" property="http://purl.org/library/placeOfPublication">{{getPlaceOfPublicationString($record->getPlacesOfPublication())}}</span> : 
        
        @if ($record->getPublisher())
        <span class="value"><span property="schema:publisher" typeof="{{$record->getPublisher()->type()}}"><span property="schema:name">{{$record->getPublisher()->getName()}}</span></span></span>
        @endif
        
        <span class="value" property="schema:datePublished">{{$record->getDatePublished()}}</span>
        <br/>
        
        @if ($record->getNumberOfPages())
        <span class="label">Physical Details: </span>
        <span class="value"><span property="schema:numberOfPages">{{$record->getNumberOfPages()}}</span> pages</span>
        <br/>
        @endif
        
        @if (count($record->getManifestations()) > 0)
        <span class="label">ISBNs:</span>
        @foreach($record->getManifestations() as $manifestation)
        <span class="value" property="schema:isbn">{{$manifestation->getISBN()}}</span>
        @endforeach
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
        
        @if ($record->getGenres())
        <h3>Genres</h3>
        <ul>
            @foreach (getDistinctGenres($record->getGenres()) as $genre)
            <li property="schema:genre">{{$genre}}</li>
            @endforeach
        </ul>
        @endif
        
        @if (count($record->getReviews()) > 0)
        <div property="schema:reviews">
            <h3>Reviews</h3>
            @foreach($record->getReviews() as $review)
            <div resource="{{$review->getUri()}}" typeof="schema:Review">
                <p property="schema:reviewBody">{{$review->getReviewBody()}}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>