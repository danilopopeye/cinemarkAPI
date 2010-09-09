<?php
require(APPPATH.'libraries/REST_Controller.php');

class api extends REST_Controller {
	function index_get(){
		$this->response(array(
			'params' => $this->uri->uri_to_assoc(),
			'error' => $this->parser->getPage('http://a.localhost'),
			'request' => $this->parser->getPage('http://is.gd')
		), 200);
	}
} 

/* End of file api.php */
/* Location: controllers/api.php */
