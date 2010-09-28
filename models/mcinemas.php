<?php

class MCinemas extends Model {
	function __construct(){
		parent::Model();
	}

	function getAll(){
		log_message('info', "Model: MCinemas -> getAll()");

		return $this->db->get('cinemas')->result_array();
	}

	function get($id = FALSE){
		if( $id === FALSE ){
			log_message('info', 'Model: MCinemas -> get() ~ invalid parameter');

			return array();
		}

		log_message('info', "Model: MCinemas -> get(". $id .")");

		return $this->db->get_where('cinemas', array(
			'id' => $id
		) )->result_array();
	}
}

?>
