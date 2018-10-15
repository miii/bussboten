<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	public function InvalidRequest()
	{
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		// Trigger error
		$this->api_model->Callback('invalid_request');
	}

	public function StopsNearby()
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		// Get routepoints
		$routepoints = $this->api_model->GetRoutepoints();
		
		// Get variables
		$latitude = (float) str_replace(',', '.', $this->input->get('latitude'));
		$longitude = (float) str_replace(',', '.', $this->input->get('longitude'));
		$line = $this->input->get('line');
		
		// Check for errors
		if ($latitude == 0 || $longitude == 0) $this->api_model->Callback('invalid_coordinates');
		else if ($line === 0) $this->api_model->Callback('invalid_line');
		
		// Get stops nearby
		$nearestStop = $this->api_model->getNearestBusStop($routepoints, $latitude, $longitude, $line);
		if ($nearestStop === null) $this->api_model->Callback('invalid_line');
		
		// Return data
		$this->api_model->Callback('request_succeeded', $nearestStop);
	}
	
	public function Departures()
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		// Get variables
		$stopID = (int) $this->input->get('stopID');
		$lineID = (int) $this->input->get('lineID');
		
		// Check for errors
		if ($stopID == 0) $this->api_model->Callback('invalid_stop');
		
		// Return data
		$this->api_model->Callback('request_succeeded', $this->api_model->getDepartures($stopID, $lineID));
	}
	
	public function NextBus()
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		// Get variables
		$stopID = (int) $this->input->get('stopID');
		$lineID = $this->input->get('lineID');
		
		// Check for errors
		if ($stopID == 0) $this->api_model->Callback('invalid_stop');
		if (!preg_match("#^[0-9,]+$#", $lineID)) $this->api_model->Callback('invalid_line');
		
		// Return data
		$this->api_model->Callback('request_succeeded', $this->api_model->getNextBus($stopID, $lineID));
		
	}
	
	public function Stops()
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		// Return data
		$this->api_model->Callback('request_succeeded', $this->api_model->getAllStops());
		
	}
	
}