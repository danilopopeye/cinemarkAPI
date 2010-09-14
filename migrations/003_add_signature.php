<?php

class Add_signature {

	function up() {

		echo "Adding field signature to comments";
		add_column ( "comments" , "signature" , STRING );

	}

	function down() {

		echo "Removing field from comments";
		remove_column ( "comments" , "signature" );

	}
}