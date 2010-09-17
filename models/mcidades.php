<?php

class MCidades extends Model {
	function __construct(){
		parent::Model();
	}

	function getAll(){
		return $this->db->get('cidades')->result_array();
	}
}

?>
