<?php

class MFilmes extends Model {
	function __construct(){
		parent::Model();
	}

	function getAll(){
		log_message('info', "Model: MFilmes -> getAll()");

		return $this->db->get('filmes')->result_array();
	}

	function get($id = FALSE){
		if( $id === FALSE ){
			log_message('info', 'Model: MFilmes -> get() ~ invalid parameter');

			return array();
		}

		log_message('info', "Model: MFilmes -> get(". $id .")");

		return $this->db->get_where('filmes', array(
			'id' => $id
		) )->result_array();
	}
}

?>
