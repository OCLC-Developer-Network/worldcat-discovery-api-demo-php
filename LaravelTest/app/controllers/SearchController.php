<?php

class SearchController extends BaseController {

    protected $layout = 'layouts.master';
    
	public function showSearchForm()
	{
		$this->layout->content = View::make('search');
	}
	
	public function showResults()
	{
	    $query = 'kw:' . Input::get('q');
	    $response = Bib::Search($query, Session::get('accessToken'));
	    if (is_a($response, '\Guzzle\Http\Exception\BadResponseException')) {
	        $error = new Error($response);
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $error));
	    } else {
	        $this->layout->content = View::make('search.results', array('title' => 'Search Results', 'search' => $response));
	    }
	}
}