<?php

class Cidades extends Controller {
	function __construct(){
		parent::Controller();

		$this->load->model('MCidades','cidades');
	}

	function findAll(){
		$this->load->view('json', array(
			'data' => $this->cidades->getAll()
		));
	}

}

/* End of file cidades.php */
/* Location: controllers/cidades.php */
