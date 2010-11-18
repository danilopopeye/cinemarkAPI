<?php
define('BR',"\n");

class api extends Controller {
	function __construct(){
		parent::Controller();

		if( $this->config->item('uri_protocol') !== 'CLI' ){
			return $this->_disclaimer();
		}
		
		$this->load->library(array(
			'curl', 'cache', 'parser'
		));
	}
	
	function _disclaimer(){
		echo 'TODO: redirect to API docs', BR;
	}

	function index(){
		echo 'TODO: some kind of help', BR;
	}

	function cidades(){
		$force = in_array('force', $this->uri->segment_array());

		echo

			'Parseando cidades...',

			$this->parser->cidades( $force ) ? 'OK' : 'Erro',
			
			BR;
	}
} 

/* End of file api.php */
/* Location: controllers/api.php */
