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
	    $options = array('facetFields' => Config::get('app.facets'));
	    
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
	    if (is_a($response, 'WorldCat\Discovery\Error')) {
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	    } else {
	        
	        $this->layout->content = View::make('search.results', array('title' => 'Search Results', 'search' => $response, 'query' => $query, 'pagination' => pagination($response), 'facetQueries' => $facetQueries));
	    }
	}
}