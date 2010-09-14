<?php

class Create_articles_schema {

	function up() {

		echo "Creating table 'articles'...";

 		create_table (
			'articles',
			array (
				'id_article' => array ( INTEGER, NOT_NULL ),
				'title' => array ( STRING, LIMIT, 50),
				'body' => TEXT,
				'date_published' => DATE,
				'author' => array ( STRING, LIMIT, 30, DEFAULT_VALUE, 'Anonymous' ),
				'visible' => BOOLEAN
			),
			'id_article'
		)
		;
		echo "DONE<br />";

		echo "Creating table 'comments'";

		create_table (
			'comments',
			array (
				'id_comment' => array ( INTEGER, NOT_NULL ),
				'body' => TEXT,
				'email' => STRING
			),
			'id_comment'
		);

		echo "DONE<br />";

	}

	function down() {

		echo "Droping table 'articles'...";
		drop_table("articles");
		echo "DONE<br />";

		echo "Droping table 'comments'...";
		drop_table("comments");
		echo "DONE<br />";

	}
}

?>