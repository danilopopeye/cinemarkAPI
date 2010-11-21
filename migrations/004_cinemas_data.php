<?php

class Cinemas_data {

	function up( $dbf, $db ) {
		echo 'Populate table "cinemas"...<br />';

		echo 'Start the transaction...';
		$db->trans_begin();

		// serialized to array
		$data = unserialize('a:52:{i:681;a:3:{s:2:"id";s:3:"681";s:4:"nome";s:17:"Midway Mall Natal";s:8:"idCidade";i:22;}i:682;a:3:{s:2:"id";s:3:"682";s:4:"nome";s:13:"Cidade Jardim";s:8:"idCidade";i:1;}i:684;a:3:{s:2:"id";s:3:"684";s:4:"nome";s:17:"Metrô Santa Cruz";s:8:"idCidade";i:1;}i:687;a:3:{s:2:"id";s:3:"687";s:4:"nome";s:10:"Shopping D";s:8:"idCidade";i:1;}i:688;a:3:{s:2:"id";s:3:"688";s:4:"nome";s:12:"Market Place";s:8:"idCidade";i:1;}i:689;a:3:{s:2:"id";s:3:"689";s:4:"nome";s:17:"Jacareí Shopping";s:8:"idCidade";i:19;}i:690;a:3:{s:2:"id";s:3:"690";s:4:"nome";s:15:"Bouled Tatuapé";s:8:"idCidade";i:1;}i:691;a:3:{s:2:"id";s:3:"691";s:4:"nome";s:23:"Plaza Shopping Niterói";s:8:"idCidade";i:20;}i:692;a:3:{s:2:"id";s:3:"692";s:4:"nome";s:16:"Carioca Shopping";s:8:"idCidade";i:9;}i:693;a:3:{s:2:"id";s:3:"693";s:4:"nome";s:15:"Canoas Shopping";s:8:"idCidade";i:12;}i:694;a:3:{s:2:"id";s:3:"694";s:4:"nome";s:12:"Campo Grande";s:8:"idCidade";i:13;}i:695;a:3:{s:2:"id";s:3:"695";s:4:"nome";s:16:"Bourbon Ipiranga";s:8:"idCidade";i:11;}i:696;a:3:{s:2:"id";s:3:"696";s:4:"nome";s:11:"Center Vale";s:8:"idCidade";i:5;}i:697;a:3:{s:2:"id";s:3:"697";s:4:"nome";s:14:"Pátio Savassi";s:8:"idCidade";i:21;}i:698;a:3:{s:2:"id";s:3:"698";s:4:"nome";s:16:"Shopping Mueller";s:8:"idCidade";i:18;}i:699;a:3:{s:2:"id";s:3:"699";s:4:"nome";s:12:"Center Norte";s:8:"idCidade";i:1;}i:700;a:3:{s:2:"id";s:3:"700";s:4:"nome";s:21:"Park Shopping Barigui";s:8:"idCidade";i:18;}i:702;a:3:{s:2:"id";s:3:"702";s:4:"nome";s:17:"Shopping Vitória";s:8:"idCidade";i:25;}i:703;a:3:{s:2:"id";s:3:"703";s:4:"nome";s:16:"Floripa Shopping";s:8:"idCidade";i:24;}i:704;a:3:{s:2:"id";s:3:"704";s:4:"nome";s:18:"Barra Shopping Sul";s:8:"idCidade";i:11;}i:705;a:3:{s:2:"id";s:3:"705";s:4:"nome";s:13:"Central Plaza";s:8:"idCidade";i:1;}i:706;a:3:{s:2:"id";s:3:"706";s:4:"nome";s:16:"Shopping Jardins";s:8:"idCidade";i:10;}i:707;a:3:{s:2:"id";s:3:"707";s:4:"nome";s:20:"Shopping Iguatemi SP";s:8:"idCidade";i:1;}i:708;a:3:{s:2:"id";s:3:"708";s:4:"nome";s:15:"Studio 5 Manaus";s:8:"idCidade";i:15;}i:709;a:3:{s:2:"id";s:3:"709";s:4:"nome";s:17:"Praiamar Shopping";s:8:"idCidade";i:8;}i:710;a:3:{s:2:"id";s:3:"710";s:4:"nome";s:9:"SP Market";s:8:"idCidade";i:1;}i:711;a:3:{s:2:"id";s:3:"711";s:4:"nome";s:15:"Metrô Tatuapé";s:8:"idCidade";i:1;}i:712;a:3:{s:2:"id";s:3:"712";s:4:"nome";s:16:"Shopping Colinas";s:8:"idCidade";i:5;}i:713;a:3:{s:2:"id";s:3:"713";s:4:"nome";s:20:"Grand Plaza Shopping";s:8:"idCidade";i:2;}i:714;a:3:{s:2:"id";s:3:"714";s:4:"nome";s:10:"Interlagos";s:8:"idCidade";i:1;}i:715;a:3:{s:2:"id";s:3:"715";s:4:"nome";s:8:"Eldorado";s:8:"idCidade";i:1;}i:716;a:3:{s:2:"id";s:3:"716";s:4:"nome";s:19:"Interlar Aricanduva";s:8:"idCidade";i:1;}i:717;a:3:{s:2:"id";s:3:"717";s:4:"nome";s:17:"Shopping Tamboré";s:8:"idCidade";i:4;}i:718;a:3:{s:2:"id";s:3:"718";s:4:"nome";s:19:"Taguatinga Shopping";s:8:"idCidade";i:17;}i:719;a:3:{s:2:"id";s:3:"719";s:4:"nome";s:8:"Downtown";s:8:"idCidade";i:9;}i:720;a:3:{s:2:"id";s:3:"720";s:4:"nome";s:7:"Pier 21";s:8:"idCidade";i:14;}i:721;a:3:{s:2:"id";s:3:"721";s:4:"nome";s:20:"Pátio Higienópolis";s:8:"idCidade";i:1;}i:723;a:3:{s:2:"id";s:3:"723";s:4:"nome";s:15:"Pátio Paulista";s:8:"idCidade";i:1;}i:724;a:3:{s:2:"id";s:3:"724";s:4:"nome";s:14:"Extra Anchieta";s:8:"idCidade";i:3;}i:725;a:3:{s:2:"id";s:3:"725";s:4:"nome";s:17:"Campinas Iguatemi";s:8:"idCidade";i:16;}i:726;a:3:{s:2:"id";s:3:"726";s:4:"nome";s:13:"Novo Shopping";s:8:"idCidade";i:6;}i:727;a:3:{s:2:"id";s:3:"727";s:4:"nome";s:11:"Villa Lobos";s:8:"idCidade";i:1;}i:728;a:3:{s:2:"id";s:3:"728";s:4:"nome";s:8:"Botafogo";s:8:"idCidade";i:9;}i:755;a:3:{s:2:"id";s:3:"755";s:4:"nome";s:15:"Shopping Riomar";s:8:"idCidade";i:10;}i:757;a:3:{s:2:"id";s:3:"757";s:4:"nome";s:15:"Cinemark Osasco";s:8:"idCidade";i:29;}i:759;a:3:{s:2:"id";s:3:"759";s:4:"nome";s:41:"Cinemark Internacional Shopping Guarulhos";s:8:"idCidade";i:27;}i:767;a:3:{s:2:"id";s:3:"767";s:4:"nome";s:21:"Cineplex Diamond Mall";s:8:"idCidade";i:21;}i:768;a:3:{s:2:"id";s:3:"768";s:4:"nome";s:20:"Cineplex BH Shopping";s:8:"idCidade";i:21;}i:769;a:3:{s:2:"id";s:3:"769";s:4:"nome";s:17:"Iguatemi Brasilia";s:8:"idCidade";i:14;}i:785;a:3:{s:2:"id";s:3:"785";s:4:"nome";s:8:"Salvador";s:8:"idCidade";i:26;}i:893;a:3:{s:2:"id";s:3:"893";s:4:"nome";s:10:"Flamboyant";s:8:"idCidade";i:23;}i:894;a:3:{s:2:"id";s:3:"894";s:4:"nome";s:19:"Shopping São José";s:8:"idCidade";i:28;}}');

		// insert each cinema
		foreach( $data as $cinema ){
			$db->insert('cinemas', $cinema); 
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
		echo 'Truncate table "cinemas"...';

		$db->truncate('cinemas');

		echo 'DONE<br />';
	}

}

?>
