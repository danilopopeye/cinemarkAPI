<?php
class cinemarkAPI {
	private $cache;
	private $salt;
	private $token;
	private $cidades;
	private $cinemas;
	private $filmes;
	private $programacao;

	function __construct() {
		$this->cache = new Cache();

		$this->salt = date("Y-F-d");

		$this->token = isset($_REQUEST['key']) ? $_REQUEST['key'] : false;
	}

	// PRIVATES
	private function verifyRequestType() {
		if ($_SERVER['REQUEST_METHOD'] != 'GET') {
			throw new Exception('Somente requisições GET são aceitas no momento');
		} else {
			if (!$this->token || !$this->verifyToken()) {
				throw new Exception('API Token inválido');
			}
		}
	}

	private function verifyToken() {
		$list = array(
			md5($this->salt.'_danilopopeye@gmail.com'),
			md5($this->salt.'_renato.thomazine@gmail.com')
		);

		return in_array($this->token, $list);
	}

	private function getAction() {
		$url = explode('/', $_SERVER['REDIRECT_URL']);
		$id = is_numeric($url[2]) ? $url[2] : false;

		switch (strtolower($url[1])) {
			case 'cidades':
				return $this->getCidades($id);
			case 'cinemas':
				return $this->getCinemas($id);
			case 'filmes':
				return $this->getFilmes($id);
			case 'programacao':
				return $this->getProgramacao($id);
			default:
				throw new Exception('Ação inválida');
		}
	}

	private function parseException($e, $die = false) {
		header('HTTP/1.1 400 Bad Request');

		$buffer = array(
			'status' => false, 'message' => $e->getMessage()
		);

		if( isset($_REQUEST['debug']) && $_REQUEST['debug'] === true ){
			$buffer['debug'] = $e->getTrace();
		}

		echo json_encode($buffer);

		if ($die) exit;
	}

	// PUBLICS
	public function run() {
		try {
			$this->verifyRequestType();

			$this->getAction();
		}
		catch(Exception $e) {
			$this->parseException($e, true);
		}
	}

	// GETS
	public function getCinemas($id = false){
		echo json_encode( $this->cache->get('cinemas', $id) );
	}

	public function getCidades($id = false){
		echo json_encode( $this->cache->get('cidades', $id) );
	}

	public function getFilmes($id = false){
		echo json_encode( $this->cache->get('filmes', $id) );
	}

	public function getProgramacao($id = false){
		echo json_encode( $this->cache->get('programacao', $id) );
	}
}
?>

