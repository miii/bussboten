<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

	public function Stop($stopName = null)
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
		
		$this->load->view('examples/stop', $data);
	}

	public function Realgymnasiet()
	{
		$this->load->view('examples/realgymnasiet');
	}

	public function All()
	{
		$this->load->driver('cache');
		$this->load->model('request_model');
		$this->load->model('api_model');
		
		$data['stops'] = $this->api_model->getAllStops();
		$this->load->view('examples/all', $data);
	}

	public function faq()
	{
		$this->load->view('info/faq');
	}
	
}