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
	            $error = new Error($response);
	            $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $error));
	        } else {
	            $this->layout->content = View::make('record', array('title' => $response->getName(), 'record' => $response));
	        }
	    }
	}
	
	
	    
}