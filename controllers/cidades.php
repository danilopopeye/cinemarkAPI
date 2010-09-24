<?php

class Cidades extends Controller {
	function __construct(){
		parent::Controller();

		$this->load->model('MCidades','cidades');
	}

	function findAll($format = DEFAULT_REST_FORMAT){
		$this->load->view($format, array(
			'data' => $this->cidades->getAll()
		));
	}

	function findById($id,$format = DEFAULT_REST_FORMAT){
		$this->load->view($format, array(
			'data' => $this->cidades->get( $id )
		));
	}

	function find($q){
		if( ! isset( $q['id'] ) || ! is_numeric( $q['id'] ) ){
			return show_error('Invalid request URI', 400);
		}
		
		if( isset( $q['format'] ) && in_array( array('json','xml'), $q['format'] ) ){
			$format = $q['format'];
		} else {
			$format = DEFAULT_REST_FORMAT;
		}

		$this->load->view($format, array(
			'data' => $this->cidades->get( $q['id'] )
		));
	}

}

/* End of file cidades.php */
/* Location: controllers/cidades.php */
