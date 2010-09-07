<?php
header('Content-Type: application/json; charset=utf-8');
require_once "include/simple_html_dom.php";
require_once "include/config.php";

$p = new Parser();

$p->parse('filme',2858);

exit;

$cache = new Cache();

print_r( $cache->get('cidades') );

print_r( $cache->get('cinemas') );

print_r( $cache->get('filmes') );

print_r( $cache->get('programacao') );
?>