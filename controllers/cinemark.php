<?php
require(APPPATH.'libraries/REST_Controller.php');

class cinemark extends REST_Controller {
	function index_get(){
		$this->response('index', 200);
	}
} 

/* End of file cinemark.php */
/* Location: controllers/cinemark.php */
