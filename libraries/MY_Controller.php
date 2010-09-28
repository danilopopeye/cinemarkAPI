<?php
/**
 * REST Controller
 */
class REST_Controller extends Controller {

	function REST_Controller() {
		$this->config =& load_class('Config');

		$this->formats = $this->config->item('REST_headers');

		parent::Controller();
	}

	function response($data, $status = 200){
		$headers = $this->config->item('REST_headers');
		$format = $this->router->format;

		if( $format != FALSE ){
			$this->output->set_header('Content-type: '. $headers[ $format ] .'; charset=utf-8;' );
		}

		$this->load->view( $format, array(
			'data' => $data
		) );
	}
}
