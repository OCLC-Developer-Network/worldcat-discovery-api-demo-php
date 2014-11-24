<?php

class RecordController extends BaseController {
	
    protected $layout = 'layouts.master';
    
	public function getByID($id)
	{
	    $options = array('heldBy' => Config::get('app.heldBy'));
	    
	    if (Config::get('app.debugAPIcalls')){
	        $options['logger'] = getLogger();
	    }
	    
	    $response = Offer::findByOclcNumber($id, Session::get('accessToken'), $options);
	    if (is_a($response, 'WorldCat\Discovery\Error')) {
	        $this->layout->content = View::make('error', array('title' => 'Error', 'error' => $response));
	    } else{
	        $creativeWorks = $response->getCreativeWorks();
	        
	        $viewVariables = array(
	            'title' => $creativeWorks[0]->getName(), 
	            'record' => $creativeWorks[0], 
	            'offers' => $response->getOffers()
	            );
	        if(Config::get('app.showIdentitiesInfo')){
	            $viewVariables['identityKnows'] = identityKnows($creativeWorks[0]->getAuthor()->getFamilyName()->getValue(), $creativeWorks[0]->getOCLCNumber()->getValue());
	        }
	        if (Config::get('app.showReccomendations')) {
	            $viewVariables['reccomendations'] = getReccomendations($creativeWorks[0]->getOCLCNumber()->getValue());;
	        }
	        $this->layout->content = View::make('record', $viewVariables);
	    }
	}
}