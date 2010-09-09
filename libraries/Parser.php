<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parser {
	function __contructor(){
		$this->ci = & get_instance();

		$this->ci->load->library('curl');
	}
} 

/* End of file Parser.php */
/* Location: libraries/Parser.php */
