<?php

class Create_table_cidades {

    function up( $dbf, $db ) {
        echo 'Creating table "cidades"...';

				$dbf->add_field('id');
				$dbf->add_field( array(
					'name' => array(
						'type' => 'VARCHAR',
						'constraint' => '100',
						'null' => FALSE
					)
				) );

				$dbf->create_table('cidades');

        echo 'DONE<br />';
    }
    
    function down( $dbf, $db ) {
        echo 'Droping table "cidades"...';

        $dbf->drop_table('cidades');

        echo 'DONE<br />';
    }

}

?>
