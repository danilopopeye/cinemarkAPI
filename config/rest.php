<?php
/**
 * Drop this file into you CodeIgniter application/config folder to enable REST handling for
 * your controllers. You also need to copy MY_Router.php into application/libraries.
 *
 * In this file you will specify which controllers will use REST handling, and how they
 * will handle it. the DEFAULT_REST_METHODS are as follows:
 *
 * $rest['MyController']= array(
 *		'find' => 'find',
 *		'findById' => 'findById',
 *		'update' => 'update',
 *		'delete' => 'delete',
 *		'add' => 'add',
 *		'findAll' => 'findAll'
 *	);
 *
 * is the same as:
 *
 * $rest['MyController'] = DEFAULT_REST_METHODS
 *
 * the signature for these methods is as follows
 *
 * function find($query):
 *		$query: 	associative array of params sent to your query
 * 		example: http://foo.com/restService/?category=true
 *
 * function findAll():
 * 		example: http://foo.com/restService/
 *
 * function findById($id):
 * 		$id: numeric id of your item (must be numeric)
 *		example: http://foo.com/restService/123
 *
 * function update($id, $data)
 * 	    $id: numeric id of your item (must be numeric)
 * 		$data: the raw post data content that should be used to update (usually json or xml)
 *
 *  function add($data)
 * 		$data: the raw post data content that should be used to add (usually json or xml)
 *
 *  function delete($id)
 * 	    $id: numeric id of your item (must be numeric)
 *
 *  If you would like to map to different methods from each of these, you
 *  can simply provide the name you prefer in the declaration of your rest service below.
 *  if there are some messages you would like to ignore (404), then you
 *  can simply omit that declaration, or set the declaration to empty string/null/false
 */

$rest['cidades'] = DEFAULT_REST_METHODS;
