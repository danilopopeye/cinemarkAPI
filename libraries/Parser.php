<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parser {
	private $ci;
	private $db;
	private $force;
	protected $urls	= array(
		'javascript' => 'http://www.cinemark.com.br/scripts/javascript_scale.js',
		'filme' => 'http://www.cinemark.com.br/horarios/bolso/?filme=' // idFilme
	);

	function __construct(){
		$this->ci =& get_instance();
		$this->db = $this->ci->db;
		$this->force = in_array('force', $this->ci->uri->segment_array());
		log_message('debug', 'Parser: Class Initialized');
	}

	public function getPage($url = FALSE){
		if( $url === FALSE ){
			return FALSE;
		}

		$this->log('Getting page: ' . $url, 'getPage');

		$get = $this->ci->curl->create( $url );

		// attempt to retrieve the modification date
		$this->ci->curl->option(CURLOPT_FILETIME, TRUE);

		return array(
			'response' => $get->execute(),
			'info' => $get->info,
			'error' => array(
				'code' => $get->error_code,
				'message' => $get->error_string
			)
		);
	}
	
	public function cidades(){
		$get = $this->getJS();

		if( $get['status'] === FALSE ){
			return $this->log( $get['message'], 'cidades', 'error' );
		}

		$this->log('Get '. count( $get['data']['cidades'] ) .' items from cidades','cidades');

		$this->db->trans_begin();
		$this->log('Started the transaction','cidades');

		$this->db->truncate('cidades');
		$this->log('Table "cidades" truncated','cidades');

		$this->log('Making the hardcore inserts','cidades');
		foreach( $get['data']['cidades'] as $id => $name ){
			$sql = $this->db->insert('cidades', array(
				'id' => $id, 'nome' => $name
			) );
		}

		$this->db->trans_complete();
		
		$s = $this->db->trans_status();

		$this->log(
			'Transaction completed with '. ( $s === TRUE ? 'SUCCESS' : 'ERROR' ),
			'cidades', ( $s === TRUE ? 'info' : 'error' )
		);
	}
	
	public function javascript($options = array()){
		$options = array_merge( array(
			'cidades' => FALSE,
			'cinemas' => FALSE,
			'filmes' => FALSE,
			'programacao' => FALSE
		), $options );

		if( ! in_array( TRUE, array_values( $options ) ) ){
			return array();
		}

		$db = $this->ci->db;

		// start the transaction
		$db->trans_begin();

		// Cidades
		if( $options['cidades'] === TRUE ){
			ksort( $Cidades );

			$db->truncate('cidades');

			foreach( $Cidades as $id => $name ){
				$sql = $db->insert('cidades', array(
					'id' => $id, 'nome' => $name
				) );
			}
		}

		// Cinemas
		if( $options['cinemas'] === TRUE ){
			$Cinemas = $this->parseCinemas( $Cinemas );

			ksort( $Cinemas );

			print_r( $Cinemas );
		}

		// Filmes
		if( $options['filmes'] === TRUE ){
			ksort( $Filmes );

			print_r( $Filmes );
		}

		// Programacao
		if( $options['programacao'] === TRUE ){
			print_r( $FilmesProgramados );
		}

		// save or discard the changes
		if( $db->trans_status() === FALSE ){
			$db->trans_rollback();
		} else {
			$db->trans_commit();
		}
	}

	// privates

	private function log( $message, $func = FALSE, $type = 'info' ){
		$buff = 'Parser :: '. ( $func === FALSE ? '' : $func . '() :: ' ) . $message;
		log_message( $type, $buff );
		echo $buff, BR;
	}

	private function getJS(){
		$filename = 'javascript';

		if( $this->force === FALSE ){
			$cache = $this->ci->cache->get( $filename );

			if( $cache['status'] === FALSE ){
				$this->log( $cache['message'], 'getJS');
			} else {
				$this->log('Getting file "'. $filename .'" from cache', 'getJS');

				return $cache;
			}
		}

		$get = $this->getPage( $this->urls[ $filename ] );

		if( $get['error']['code'] != 0 ){
			$this->log('Error getting the page: '. $this->urls[ $filename ], 'getPage', 'error' );

			return array(
				'status' => FALSE,
				'message' => $get['error']['code'] .': '. $get['error']['message']
			);
		}

		// encode the response to UTF8
		$file = utf8_encode( $get['response'] );

		$file = str_replace('var', '', $file);

		$file = str_replace('new Array', 'array', $file);

		$file = str_replace('_', '$', $file);

		$file = str_replace('idx', '$idx', $file);

		$file = str_replace("'\n", "';\n", $file);

		$file = str_replace("<!--", "", $file);
		$file = str_replace("//-->", "", $file);

		if( eval( $file ) === FALSE ){
			return array(
				'status' => FALSE, 'message' => "syntax error, eval()'d code"
			);
		}

		return $this->ci->cache->write( array(
			'cidades' => $Cidades,
			'cinemas' => $this->parseCinemas( $Cinemas ),
			'filmes' => $Filmes,
			'programacao' => $FilmesProgramados
		), $filename );
	}

	private function parseItem($k, $v, $t) {
		return array(
			$t['id'] => $k, $t['name'] => $v
		);
	}

	private function parseArray($c, $t, $id = false) {
		if (!is_array($c)) {
			return array();
		} elseif ($id) {
			return $this->parseItem($id, $c[$id], $t);
		} else {
			$b = array();

			foreach ($c as $k => $v) {
				$b[ $k ] = $this->parseItem($k, $v, $t);
			}

			return $b;
		}
	}

	private function parseCinemas($c) {
		if (!is_array($c)) {
			return array();
		} else {
			$b = array();

			foreach ($c as $id => $value) {
				for ($i = 0, $l = count($value); $i < $l; $i++) {
					$b[ $value[$i] ] = array(
						'id' => $value[$i++], 'name' => $value[$i], 'idCidade' => $id
					);
				}
			}

			return $b;
		}
	}
} 

/* End of file Parser.php */
/* Location: libraries/Parser.php */
