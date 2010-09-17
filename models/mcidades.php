<?php

class MCidades extends Model {
	function __construct(){
		parent::Model();
	}

	function getAll(){
		log_message('info', "Model: MCidades -> getAll()");

		return $this->db->get('cidades')->result_array();
	}

	function get($id = FALSE){
		if( $id === FALSE ){
			log_message('info', 'Model: MCidades -> get() ~ invalid parameter');

			return array();
		}

		log_message('info', "Model: MCidades -> get(". $id .")");

		return $this->db->get_where('cidades', array(
			'id' => $id
		) )->result_array();
	}
}

?>
