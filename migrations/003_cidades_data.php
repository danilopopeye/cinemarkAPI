<?php

class Cidades_data {

	function up( $dbf, $db ) {
		echo 'Populate table "cidades"...<br />';

		echo 'Start the transaction...';
		$db->trans_begin();

		// serialized to array
		$data = unserialize( 'a:28:{i:0;a:2:{s:2:"id";i:1;s:4:"nome";s:10:"São Paulo";}i:1;a:2:{s:2:"id";i:2;s:4:"nome";s:12:"Santo André";}i:2;a:2:{s:2:"id";i:3;s:4:"nome";s:22:"São Bernardo do Campo";}i:3;a:2:{s:2:"id";i:4;s:4:"nome";s:7:"Barueri";}i:4;a:2:{s:2:"id";i:5;s:4:"nome";s:21:"São José dos Campos";}i:5;a:2:{s:2:"id";i:6;s:4:"nome";s:15:"Ribeirão Preto";}i:6;a:2:{s:2:"id";i:8;s:4:"nome";s:6:"Santos";}i:7;a:2:{s:2:"id";i:9;s:4:"nome";s:14:"Rio de Janeiro";}i:8;a:2:{s:2:"id";i:10;s:4:"nome";s:7:"Aracaju";}i:9;a:2:{s:2:"id";i:11;s:4:"nome";s:12:"Porto Alegre";}i:10;a:2:{s:2:"id";i:12;s:4:"nome";s:6:"Canoas";}i:11;a:2:{s:2:"id";i:13;s:4:"nome";s:12:"Campo Grande";}i:12;a:2:{s:2:"id";i:14;s:4:"nome";s:9:"Brasília";}i:13;a:2:{s:2:"id";i:15;s:4:"nome";s:6:"Manaus";}i:14;a:2:{s:2:"id";i:16;s:4:"nome";s:8:"Campinas";}i:15;a:2:{s:2:"id";i:17;s:4:"nome";s:10:"Taguatinga";}i:16;a:2:{s:2:"id";i:18;s:4:"nome";s:8:"Curitiba";}i:17;a:2:{s:2:"id";i:19;s:4:"nome";s:8:"Jacareí";}i:18;a:2:{s:2:"id";i:20;s:4:"nome";s:8:"Niterói";}i:19;a:2:{s:2:"id";i:21;s:4:"nome";s:14:"Belo Horizonte";}i:20;a:2:{s:2:"id";i:22;s:4:"nome";s:5:"Natal";}i:21;a:2:{s:2:"id";i:23;s:4:"nome";s:8:"Goiânia";}i:22;a:2:{s:2:"id";i:24;s:4:"nome";s:14:"Florianópolis";}i:23;a:2:{s:2:"id";i:25;s:4:"nome";s:8:"Vitória";}i:24;a:2:{s:2:"id";i:26;s:4:"nome";s:8:"Salvador";}i:25;a:2:{s:2:"id";i:27;s:4:"nome";s:9:"Guarulhos";}i:26;a:2:{s:2:"id";i:28;s:4:"nome";s:22:"São José dos Pinhais";}i:27;a:2:{s:2:"id";i:29;s:4:"nome";s:6:"Osasco";}}' );

		// insert each cidade
		foreach( $data as $cidade ){
			$db->insert('cidades', $cidade); 
		}

		// save or discard the changes
		if( $db->trans_status() === FALSE ){
			echo 'Rollback...';
			$db->trans_rollback();
		} else {
			echo 'Commit...';
			$db->trans_commit();
		}

		echo 'DONE<br />';
	}
    
	function down( $dbf, $db ) {
		echo 'Truncate table "cidades"...';

		$db->truncate('cidades');

		echo 'DONE<br />';
	}

}

?>
