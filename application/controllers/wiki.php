<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	public function InvalidRequest()
	{
		$data['content'] = $this->load->view('wiki/wiki_content', '', true);
		$this->load->view('wiki/wiki', $data);
	}
	
}