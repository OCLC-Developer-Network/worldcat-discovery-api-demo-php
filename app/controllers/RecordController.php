<?php

class RecordController extends BaseController {
	
    protected $layout = 'layouts.master';
    
	public function getByID($id)
	{
	    if (Cache::has($id)) {
	        return View::make('record', array('record' => Cache::get($id)));
	    } else {
	        $response = Bib::Find((int) $id, Session::get('accessToken'));
	        if (is_a($response, '\Guzzle\Http\Exception\BadResponseException')) {
	            $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	        } else {
	            if (Request::header('Accept') == 'application/rdf+xml')
	            {
	                $response->getGraph()->load($response->getAuthor()->getDbpediaUri());
	                return Response::make($response->getGraph()->serialise('rdfxml'), 200, array('Content-Type' => 'application/rdf+xml'));
	            } else { 
	               $dbpediaPerson = loadDbpedia($response->getAuthor()->getDbpediaUri());
	               $this->layout->content = View::make('record', array('title' => $response->getName(), 'record' => $response, 'dbpediaPerson' => $dbpediaPerson));
	            }
	        }
	    }
	}
	
	
	    
}