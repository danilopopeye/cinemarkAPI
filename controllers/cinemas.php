<?php

class Cinemas extends REST_Controller {
	function __construct(){
		parent::REST_Controller();

		$this->load->model('MCinemas','cinemas');
	}

	function findAll(){
		$this->response(
			$this->cinemas->getAll()
		);
	}

	function findById($id){
		$this->response(
			$this->cinemas->get( $id )
		);
	}

	function find($q){
		if( ! isset( $q['id'] ) || ! is_numeric( $q['id'] ) ){
			return show_error('Invalid request URI', 400);
		}

		$this->response(
			$this->cinemas->get( $q['id'] )
		);
	}

}

/* End of file cinemas.php */
/* Location: controllers/cinemas.php */
