<?php
header('Content-Type: application/json; charset=utf-8'); 
require_once "include/simple_html_dom.php"; 
require_once "include/config.php";

$api = new cinemarkAPI();

$api->run();
?>