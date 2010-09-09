<?php
require(APPPATH.'libraries/REST_Controller.php');

class cinemark extends REST_Controller {
	function index_get(){
		$this->load->library('Parser');
		$this->response(array(
			'params' => $this->uri->uri_to_assoc()
		), 200);
	}
} 

/* End of file cinemark.php */
/* Location: controllers/cinemark.php */
