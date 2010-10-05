<?php
/**
 * REST Controller
 */
class REST_Controller extends Controller {

	function REST_Controller() {
		parent::Controller();

		$this->formats = $this->config->item('REST_headers');

		$this->verifyKey();

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

	private function verifyKey(){
		if( $this->config->item('REST_key') === TRUE ){
			$key = $this->router->key;
		}
	}
}
