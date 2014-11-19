<?php
function identityKnows($authorFamilyName, $oclcNumber){
    $identityURI = getIdentityURI($authorFamilyName, $oclcNumber);
    $graph = getIdentityGraph($identityURI);
    $identityKnows = $graph->resource($identityURI)->allResources('schema:knows');
    
    return $identityKnows;
}

function getIdentityURI($authorFamilyName, $oclcNumber){
    $identityOpenURL = 'http://www.worldcat.org/identities/find?url_ver=Z39.88-2004&rft_val_fmt=info:ofi/fmt:kev:mtx:identity&';
    $identityOpenURL .= 'rft.namelast=' . $authorFamilyName  . '&rft_id=info:oclcnum/' . $oclcNumber;
    $identity_xml = simplexml_load_file($identityOpenURL);
    $identityURI = 'http://www.worldcat.org/identities/' . urlencode($identity_xml->match->key);
    return $identityURI;
}

function getIdentityGraph($identityURI){
    $identityGraph = new EasyRDF_Graph($identityURI);
    $identityGraph->load();
    foreach ($identityGraph->resource($identityURI)->allResources('schema:knows') as $knows){
        $uri = str_replace(', ', urlencode(', '), $knows->getURI());
        $identityGraph->load($uri);
    }
    return $identityGraph;
}

function getReccomendations($oclcNumber){
    $reccomenderRequestURL = 'http://experimental.worldcat.org/recommender/MLT/'. $oclcNumber;
    $reccomenderXML = simplexml_load_file($reccomenderRequestURL);
    $reccomenderXML->registerXPathNamespace('recs', 'http://recommender.oclc.org');
    $reccomendations = $reccomenderXML->xpath('//recs:likeItems/recs:likeItem');
    
    array_walk($reccomendations, function(&$reccomendation)
    {
        $reccomendation = array('title' => $reccomendation->attributes()->title, 'oclcNumber' => $reccomendation->attributes()->ocn);
    });

    return $reccomendations;
}

function getAvailability($oclcNumber, $seller){
    $registryID = substr($seller->getURI(), strrpos($seller->getURI(), '/') +1);
    $availabilityURL = Config::get('app.WMSAvailabilityAPIURL') . '/sru/service?x-registryId=' . $registryID . '&query=no:'. $oclcNumber;
    
    $accessToken = Session::get('wskey')->getAccessTokenWithClientCredentials(Config::get('app.institutionID'), $registryID);
    if (!$accessToken->getErrorCode()){    
        $guzzleOptions = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $accessToken->getValue()
                )
            );
        try {
            $response = \Guzzle::get($availabilityURL, $guzzleOptions);
            $availabilityXML = $response->xml();
            $copies = $availabilityXML->xpath('//holdings/holding');
            array_walk($copies, function (&$copy)
            {
                $copy = array(
                    'branchLocation' => $copy->localLocation,
                    'shelvingLocation' => $copy->shelvingLocation,
                    'callNumber' => $copy->callNumber,
                    'holds' => $copy->circulations->circulation->onHold->attributes()->value,
                    'available' => ($copy->circulations->circulation->availableNow->attributes()->value == true) ? 'On the shelf' : 'Checked Out'
                );
            });
        } catch (\Guzzle\Http\Exception\BadResponseException $error) {
            $copies = null;
        }
    } else {
        $copies = null;
    }
    
    return $copies;
}

function getAuthorString($authors){
    $i = 0;
    $authorsString = '';
    foreach ($authors as $key => $author){
        $authorsString .= '<span id="author" property="schema:author" resource="{{$author->getUri()}}" typeof="' . $author->type() . '">';
        $authorsString .= '<span id="author-name" property="schema:name">';
        $authorsString .= $author->getName();
        $authorsString .= '</span>';
        $authorsString .= '</span>';
        if (++$i != count($authors)){
            $authorsString .= ', ';
        }
    }
    
    return $authorsString;
}
function getPlaceOfPublicationString($placesOfPublication){
    if (count($placesOfPublication) == 1){
        return $placesOfPublication;
    } else {
        $places = array();
        foreach($placesOfPublication as $place){
            if ($place->get('schema:name')){
                $places[] = $place->getName();
            }
        }
        return implode(',', $places);
    }
}

function getDescriptionString($descriptions)
{
    if (is_array($descriptions)){
        return implode(' ', $descriptions);
    } else {
        return $descriptions->getValue();
    }
}

function getLanguageString($language)
{
    $languageFile = Yaml::parse(app_path() . '/config/languages.yml');
    return $languageFile[$language->getValue()];
}

function getMarcLanguageString($language)
{
    $languageFile = Yaml::parse(app_path() . '/config/marclanguages.yml');
    return $languageFile[$language->getValue()];
}


function getFormatString($format){
    if (strchr($format, '/')) {
        $format = substr(strchr($format, '/'), 1);
    } else {
        $format = substr(strchr($format, ':'), 1);
    }
    return $format;
}

function getDistinctGenres($genres)
{
    array_walk($genres, function(&$genre)
    {
        $genre = rtrim($genre, '.');
    });
    $distinctGenres = array_unique($genres);
    return $distinctGenres;
}

function getDisplaySubjects($subjects)
{
    $displaySubjects = array_merge(getVIAFSubjects($subjects), getFASTSubjects($subjects));
    return $displaySubjects;
}

function getVIAFSubjects($subjects)
{
    $viafSubjects = array_filter($subjects, function($subject)
    {
        return(strpos($subject->getURI(), 'viaf'));
    });
    return $viafSubjects;
}

function getFASTSubjects($subjects)
{
    $fastSubjects = array_filter($subjects, function($subject)
    {
        return(strpos($subject->getURI(), 'fast'));
    });
    return $fastSubjects;
}

function camelCaseToTitle($facetIndex)
{
    $output = "";
    foreach( str_split( $facetIndex ) as $char ) {
            strtoupper( $char ) == $char and $output and $output .= " ";
            $output .= $char;
    }
    return ucwords($output);
}

function getFulltextLink($record){
    $kbrequest = Config::get('app.WorldCatKnowledgebaseAPIURL') . "/openurl/resolve?";
    if (is_a($record, 'WorldCat\Discovery\Article')){
        if ($record->getSameAs()){
            $doi = str_replace("http://dx.doi.org/", "info:doi:", $record->getSameAs());
            $kbrequest .= 'rft_id=' . $doi;
        } else {
            $kbrequest .= "rft.issn=" . $record->getIsPartOf()->getVolume()->getPeriodical()->getIssn();
            $kbrequest .= "&rft.volume=" . $record->getIsPartOf()->getVolume()->getVolumeNumber();
            $kbrequest .= "&rft.issue=" . $record->getIsPartOf()->getIssueNumber();
            $kbrequest .= "&rft.spage=" . $record->getPageStart();
            $kbrequest .= "&rft.atitle=" . $record->getName();
        }
    } elseif (get_class($record) == "Book" && $record->getManifestations()) {
        $manifestations = $record->getManifestations();
        $kbrequest .= "rft.isbn=" . $manifestations[0]->getISBN();
    }else {
        $kbrequest .= "rft.oclcnum=" . $record->getOCLCNumber();
    }
    $kbrequest .= '&wskey=' . Config::get('app.wskey');
     
    $kbresponse = json_decode(file_get_contents($kbrequest), true);
    
    if (isset($kbresponse[0]['url'])){
        return $kbresponse[0]['url'];
    }
}

function getFacetDisplayName($facet, $facetValue)
{
    switch ($facet->getFacetIndex()) {
    	case 'inLanguage':
    	    $displayName = getMarcLanguageString($facetValue->getName()) . ' ' . $facetValue->getCount();
    	    break;
    	case 'author':
    	case 'about':
    	case 'genre':
    	    $displayName = ucwords($facetValue->getName()) . ' ' . $facetValue->getCount();
    	    break;
    	default:
    	    $displayName = $facetValue->getName() . ' ' . $facetValue->getCount();
    	    break;
    	    
    }
    return $displayName;
}

function getFacetRefineQueryString($facet, $facetValue, $facetQueries = array(), $remove = false)
{
    if ($remove){
        unset($facetQueries[$facet]);
    } else {
        if (empty($facetQueries[(string)$facet])){
            $facetQueries[(string)$facet] = $facetValue;
        }
    }
    
    return getFacetQueryString($facetQueries);
}

function getFacetQueryString($facetQueries){
    $facetQueriesString = '';
    
    foreach ($facetQueries as $facetQueryKey => $facetQueryValue){
        $facetQueriesString .= $facetQueryKey . ':' . $facetQueryValue;
        if ($facetQueryValue != end($facetQueries)){
            $facetQueriesString .= ',';
        }
    }
    return $facetQueriesString;
}

function convertFacetQueriesToArray($facetQueriesString){
    $facetQueries = explode(',', $facetQueriesString);
    $i = 0;
    foreach ($facetQueries as $facetQuery){
        $facetQuery = explode(':', $facetQuery);
        $facetQueries[$facetQuery[0]] = $facetQuery[1];
        unset($facetQueries[$i]);
        $i++;
    }
    return $facetQueries;
}

function pagination($search)
{
    $pagination = array();
    $pagination['first'] = $search->getStartIndex() +1;
    $pagination['last'] = $pagination['first'] + $search->getItemsPerPage() -1;
    $pagination['total'] = $search->getTotalResults();
    $pagination['next_page_start'] = ($pagination['first'] + $search->getItemsPerPage() -1) > $search->getTotalResults() ? null : $pagination['first'] + $search->getItemsPerPage() -1;
    $pagination['previous_page_start'] = ($pagination['first'] - 11) < 0 ? null : $pagination['first'] - 11;
    return $pagination;
}