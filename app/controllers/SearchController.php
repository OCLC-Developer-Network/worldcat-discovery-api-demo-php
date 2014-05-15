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
	    $facets = array('author' => 10, 'inLanguage' => 10);
	    $options = array('facets' => $facets);
	    $response = Bib::Search($query, Session::get('accessToken'), $options);
	    if (is_a($response, '\Guzzle\Http\Exception\BadResponseException')) {
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	    } else {
	        $this->layout->content = View::make('search.results', array('title' => 'Search Results', 'search' => $response));
	    }
	}
}