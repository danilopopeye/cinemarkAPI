<?php

class MCidades extends Model {
	function __construct(){
		parent::Model();
	}

	function getAll(){
		log_message('info', "Model: MCidades -> getAll");

		return $this->db->get('cidades')->result_array();
	}
}

?>
