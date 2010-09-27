<?php

class Cidades extends REST_Controller {
	function __construct(){
		parent::Controller();

		$this->load->model('MCidades','cidades');
	}

	function findAll(){
		$this->response(
			$this->cidades->getAll()
		);
	}

	function findById($id){
		$this->response(
			$this->cidades->get( $id )
		);
	}

	function find($q){
		if( ! isset( $q['id'] ) || ! is_numeric( $q['id'] ) ){
			return show_error('Invalid request URI', 400);
		}

		$this->response(
			$this->cidades->get( $q['id'] )
		);
	}

}

/* End of file cidades.php */
/* Location: controllers/cidades.php */
