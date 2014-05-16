<?php

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

function getFacetDisplayName($facet, $facetValue)
{
    switch ($facet->getFacetIndex()) {
    	case 'srw.ln':
    	    $displayName = getMarcLanguageString($facetValue->getName()) . ' ' . $facetValue->getCount();
    	    break;
    	case 'srw.ap':
    	    $displayName = ucwords($facetValue->getName()) . ' ' . $facetValue->getCount();
    	    break;
    	default:
    	    $displayName = $facetValue->getName() . ' ' . $facetValue->getCount();
    	    break;
    	    
    }
    return $displayName;
}

function getFacetRefineQuery($query, $facet, $facetValue)
{
    return $query . ' AND ' . $facet->getFacetIndex() . ':' . $facetValue->getName();
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