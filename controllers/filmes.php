<?php

class Filmes extends REST_Controller {
	function __construct(){
		parent::REST_Controller();

		$this->load->model('MFilmes','filmes');
	}

	function findAll(){
		$this->response(
			$this->filmes->getAll()
		);
	}

	function findById($id){
		$this->response(
			$this->filmes->get( $id )
		);
	}

	function find($q){
		if( ! isset( $q['id'] ) || ! is_numeric( $q['id'] ) ){
			return show_error('Invalid request URI', 400);
		}

		$this->response(
			$this->filmes->get( $q['id'] )
		);
	}

}

/* End of file filmes.php */
/* Location: controllers/filmes.php */
