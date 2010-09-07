<?php
class Parser {
	private $cache;
	private $html;
	protected $urls	= array(
		'javascript' => 'http://www.cinemark.com.br/scripts/javascript_scale.js',
		'filme' => 'http://www.cinemark.com.br/horarios/bolso/?filme=' // idFilme
	);

	function __construct(){
		$this->cache	= new Cache();
		$this->html		= new simple_html_dom();

		if( func_num_args() ){
			$this->parse( );
		}
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
						'cinema_id' => $value[$i++], 'cinema_name' => $value[$i], 'city_id' => $id
					);
				}
			}

			return $b;
		}
	}

	private function hasExpired( $name ) {
		return ( time() - filemtime( TEMP_DIR . $name ) ) > EXPIRE_TIME;
	}

	private function has( $name ) {
		return file_exists( TEMP_DIR . $name );
	}

	private function get( $url, $file ){
		return file_put_contents( TEMP_DIR . $file, file_get_contents( $url ) );
	}

	private function getHtml($file){
		return str_get_html(
			utf8_encode(
				file_get_contents( TEMP_DIR . $file )
			)
		);
	}

	private function parseJSFile() {
		$filename = 'javascript';

		if( !$this->has( $filename ) || $this->hasExpired( $filename ) ){
			$this->get( $this->urls[ $filename ], $filename );
		}

		$file = utf8_encode(
			file_get_contents( TEMP_DIR . $filename )
		);

		$file = str_replace('var', '', $file);

		$file = str_replace('new Array', 'array', $file);

		$file = str_replace('_', '$', $file);

		$file = str_replace('idx', '$idx', $file);

		$file = str_replace("'\n", "';\n", $file);

		$file = str_replace("<!--", "", $file);
		$file = str_replace("//-->", "", $file);

		eval( $file );

		$this->cache->save( 'filmes', $this->parseArray(
			$Filmes, array( 'id' => 'movie_id', 'name' => 'movie_name' )
		) );

		$this->cache->save( 'cidades', $this->parseArray(
			$Cidades, array( 'id' => 'city_id', 'name' => 'city_name' )
		) );

		$this->cache->save( 'programacao', $this->parseArray(
			$FilmesProgramados, array( 'id' => 'cinema_id', 'name' => 'movie_id' )
		) );

		$this->cache->save( 'cinemas', $this->parseCinemas( $Cinemas ) );
	}

	private function parseFilme( $id ){
		$file	= 'filme_'. $id;
		$filme	= array(
			'id' => $id
		);

		$tCinemas = $this->cache->get('cinemas');

		foreach( $tCinemas as $cinema ){
			$cinemas[ $cinema['cinema_name'] ] = $cinema['_id'];
		}

		if( !$this->has( $file ) || $this->hasExpired( $file ) ){
			$this->get( $this->urls['filme'] . $id, $file );
		}

		$this->html = $this->getHtml( $file );

		$n_c = explode(' - ',$this->html->find('div.nome',0)->plaintext);

		$filme['nome'] = trim( $n_c[0] );

		$filme['classificacao'] = trim( $n_c[1] );

		$filme['poster'] = 'http://www.cinemark.com.br/filmes/'. $id .'/photo1.jpg';

		$filme['sinopse'] = $this->html->find('div.sinopse',0)->plaintext;

		$g_m = explode('/', $this->html->find('div.genero_min',0)->plaintext);

		$filme['genero'] = trim( $g_m[0] );

		$filme['duracao'] = (int)trim( $g_m[1] );

		foreach( $this->html->find('div.titulo') as $titulo ){
			$idCinema = $cinemas[ trim( $titulo->plaintext ) ];

			$filme['cinemas'][ $idCinema ] = array(
				'id' => $idCinema,
				'sessoes' => explode(' - ', $titulo->next_sibling()->plaintext)
			);
		}

		echo json_encode( $filme );
		exit;
	}

	public function parse( $name, $id = false ){
		switch( $name ){
			case 'filmes':
			case 'cidades':
			case 'cinemas':
			case 'programacao':
				$this->parseJSFile(); break;
			case 'filme':
				$this->parseFilme( $id ); break;
		}
	}
}
?>

