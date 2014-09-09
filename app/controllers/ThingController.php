<?php

class ThingController extends BaseController {
	
    protected $layout = 'layouts.master';
    
	public function getByURI()
	{
	    $uri = Input::get('uri');
	    $response = WorldCat\Discovery\Thing::findByURI($uri);
        if (is_a($response, 'WorldCat\Discovery\Person')) {
            $dbpediaInfo = Thing::findByURI($response->getDbpediaUri());
            $this->layout->content = View::make('person', array('title' => $response->getName(), 'person' => $response, 'dbpediaInfo' => $dbpediaInfo));
        } else {
            $this->layout->content = View::make('thing', array('title' => $response->getName(), 'thing' => $response));
        }
	}
}