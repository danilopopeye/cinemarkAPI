<?php
define('BR',"\n");
define('TAB',"\t");

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
		echo BR,
			'Parsing cidades...', BR,
			$this->parser->cidades(), BR;
	}

	function cinemas(){
		echo BR,
			'Parsing cinemas...', BR,
			$this->parser->cinemas(), BR;
	}
} 

/* End of file api.php */
/* Location: controllers/api.php */
