<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Android extends CI_Controller {

	public function Auto($version = false)
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		$this->load->model('example_model');
		
		$data['stops'] = $this->api_model->getAllStops();
		$data['version'] = $version;
		
		$this->load->view('examples/android/all', $data);
	}

	public function Stop($stopName)
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		$this->load->model('example_model');
		
		$data['stops'] = $this->api_model->getAllStops();
		$data['stopURL'] = $stopName;
		
		list($data['stopName'], $data['stopID'], $data['lat'], $data['long']) = $this->example_model->GetStopID($stopName);
		if ($data['stopID'] === null)
			return $this->All();
		
		$this->load->view('examples/android/stop', $data);
	}
	
}