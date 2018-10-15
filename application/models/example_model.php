<?php

class Example_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function GetStopID($stopName)
	{	
		$routepoints = $this->api_model->GetRoutepoints();
		
		foreach($routepoints->Stops as $stops)
			$stopUrls[$this->api_model->toAscii($stops->name)] = array(
				$stops->name,
				$stops->stopID,
				$stops->latitude,
				$stops->longitude
			);
		
		return isset($stopUrls[$stopName]) ? $stopUrls[$stopName] : false;
	}
	
}