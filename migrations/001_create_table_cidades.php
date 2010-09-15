<?php

class Create_table_cidades {

    function up( $db ) {
        echo 'Creating table "cidades"...';

				$db->add_field('id');
				$db->add_field( array(
					'name' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => FALSE
					)
				) );

				$db->create_table('cidades');

        echo 'DONE<br />';
    }
    
    function down( $db ) {
        echo 'Droping table "cidades"...';

        $db->drop_table('cidades');

        echo 'DONE<br />';
    }

}

?>
