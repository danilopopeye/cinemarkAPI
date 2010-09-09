<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parser {
	private $ci;

	function __construct(){
		$this->ci =& get_instance();
		log_message('debug', 'Parser: Class Initialized');
	}

	function getPage($url = FALSE){
		if( $url === FALSE ){
			return FALSE;
		}

		$get = $this->ci->curl->create( $url );

		return array(
			'response' => $get->execute(),
			'info' => $get->info,
			'error' => array(
				'code' => $get->error_code,
				'message' => $get->error_string
			)
		);
	}
} 

/* End of file Parser.php */
/* Location: libraries/Parser.php */
