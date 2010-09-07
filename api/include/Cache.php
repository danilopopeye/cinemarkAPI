<?php
class Cache {
	private function hasExpired( $file ) {
		return ( time() - filemtime( CACHE_DIR . $file ) ) > EXPIRE_TIME;
	}

	private function has( $name ){
		return file_exists( CACHE_DIR . $name );
	}

	public function save( $name, $data ){
		return file_put_contents(
			CACHE_DIR . $name, serialize( $data )
		);
	}

	private static function getCache( $name ){
		return unserialize(
			file_get_contents( CACHE_DIR . $name )
		);
	}

	public function get( $name, $id = false ){
		if( !$this->has( $name ) || $this->hasExpired( $name ) ){
			$Parser = new Parser();
			$Parser->parse( $name );
		}

		$data = Cache::getCache( $name );

		return $id ? $data[ $id ] : $data;
	}

	public function getFilmes( $id = false ){
		if( !$id ){
			return $this->get('filmes');
		}

		$name = 'filmes_' . $id;

		if( !$this->has( $name ) || $this->hasExpired( $name ) ){
			$Parser = new Parser();
			$Parser->parse( $name );
		}
	}
}
?>

