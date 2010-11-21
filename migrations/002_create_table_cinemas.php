<?php

class Create_table_cinemas {

    function up( $db ) {
        echo 'Creating table "cinemas"...';

				$db->add_field('id');
				$db->add_field( array(
					'idCidade' => array(
						'type' => 'INT',
						'null' => FALSE
					),
					'nome' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => FALSE
					),
					'endereco' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => TRUE
					),
					'telefone' => array(
						'type' => 'INT',
						'null' => TRUE 
					)
				) );

				$db->create_table('cinemas');

        echo 'DONE<br />';
    }
    
    function down( $db ) {
        echo 'Droping table "cinemas"...';

        $db->drop_table('cinemas');

        echo 'DONE<br />';
    }

}

?>
