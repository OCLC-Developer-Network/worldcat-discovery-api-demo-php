<?php

class SearchController extends BaseController {

    protected $layout = 'layouts.master';
    
	public function showSearchForm()
	{
		$this->layout->content = View::make('search');
	}
	
	public function showResults()
	{
	    $query = Input::get('q');
	    $facets = array('about' => 10, 'author' => 10, 'datePublished' => 10, 'genre' => 10, 'itemType' => 10, 'inLanguage' => 10);
	    $options = array('facetFields' => $facets);
	    
	    if (Input::get('facetQueries')){
	        $facetQueries = convertFacetQueriesToArray(Input::get('facetQueries'));
	        $options['facetQueries'] = $facetQueries;
	    } else {
	        $facetQueries = array();
	    }
	    
	    if (Input::get('startNum')){
	        $options['startNum'] = Input::get('startNum');
	    }
	    
	    $response = Bib::Search($query, Session::get('accessToken'), $options);
	    if (is_a($response, '\Guzzle\Http\Exception\BadResponseException')) {
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	    } else {
	        
	        $this->layout->content = View::make('search.results', array('title' => 'Search Results', 'search' => $response, 'query' => $query, 'pagination' => pagination($response), 'facetQueries' => $facetQueries));
	    }
	}
}