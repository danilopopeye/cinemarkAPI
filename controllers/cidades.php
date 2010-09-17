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

	function findById($id){
		$this->load->view('json', array(
			'data' => $this->cidades->get( $id )
		));
	}

	function find($q){
		if( ! isset( $q['id'] ) || ! is_numeric( $q['id'] ) ){
			return show_error('Invalid request URI', 400);
		}

		$this->load->view('json', array(
			'data' => $this->cidades->get( $q['id'] )
		));
	}

}

/* End of file cidades.php */
/* Location: controllers/cidades.php */
