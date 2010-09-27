<?php

function loopable( $data ){
	if( ! is_array( $data ) && ! is_object( $data ) ){
		$data = (array) $data;
	}

	return $data;
}

function rawxml($data = array(), $structure = NULL, $basenode = 'xml'){
	if( ini_get('zend.ze1_compatibility_mode') == 1 ){
		ini_set ('zend.ze1_compatibility_mode', 0);
	}

	if( $structure == NULL ){
		$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><". $basenode ." />");
	}

	$data = loopable( $data );

	foreach( $data as $key => $value ){
		if( is_numeric( $key ) ){
			$key = "item";
		} else {
			$key = preg_replace('/[^a-z0-9_-]/i', '', $key);
		}

		if( is_array( $value ) || is_object( $value ) ){
			$node = $structure->addChild( $key );
			rawxml( $value, $node, $basenode );
		} else {
			$value = htmlentities( $value, ENT_NOQUOTES, "UTF-8" );

			$structure->addChild( $key, $value );
		}
	}

	return $structure->asXML();
}

echo rawxml( $data );

?>
