<?php

class Create_table_filmes {

    function up( $dbf, $db ) {
        echo 'Creating table "filmes"...';

				$dbf->add_field('id');
				$dbf->add_field( array(
					'nome' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE
					),
					'direcao' => array(
						'type' => 'VARCHAR',
						'constraint' => '255'
					),
					'duracao' => array(
						'type' => 'INT',
						'UNSIGNED' => TRUE
					),
					'classificacao' => array(
						'type' => 'TINYINT',
						'UNSIGNED' => TRUE
					),
					'sinopse' => array(
						'type' => 'TEXT'
					),
					'parsed' => array(
						'type' => 'INT'
					)
				) );

				$dbf->create_table('filmes');

        echo 'DONE<br />';
    }
    
    function down( $dbf, $db ) {
        echo 'Droping table "filmes"...';

        $dbf->drop_table('filmes');

        echo 'DONE<br />';
    }

}

?>
