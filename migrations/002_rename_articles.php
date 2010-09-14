<?php
class Rename_articles {

	function up() {

		echo "Renaming table...";
		rename_table("articles", "blogs");
		echo "DONE";

	}

	function down() {

		echo "Renaming table...";
		rename_table("blogs", "articles");
		echo "DONE";

	}

}
?>