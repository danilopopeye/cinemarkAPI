<?php

function format( $data = array() ){
	if( isset( $data[0] ) ){
		$headings = array_keys($data[0]);
	} else {
		$headings = array_keys($data);
		$data = array( $data );
	}

	$output = implode(',', $headings)."\r\n";
	foreach( $data as &$row ){
		$output .= '"'. implode('","',$row) ."\"\r\n";
	}

	return $output;
}

echo format( $data );

?>
