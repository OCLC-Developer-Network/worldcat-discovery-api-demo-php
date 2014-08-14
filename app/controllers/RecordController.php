<?php

class RecordController extends BaseController {
	
    protected $layout = 'layouts.master';
    
	public function getByID($id)
	{
	    $response = Bib::Find($id, Session::get('accessToken'));
	    
	    if (is_a($response, 'WorldCat\Discovery\Error')) {
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	    } elseif(is_a($response, 'WorldCat\Discovery\Article')) {
	        $this->layout->content = View::make('article', array('title' => $response->getName(), 'record' => $response));
	    } else {
	        $this->layout->content = View::make('record', array('title' => $response->getName(), 'record' => $response));
	    }
	}
}