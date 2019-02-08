<?php

header("Content-Type: text/html; Charset=ISO-8859-1", true);

?>

<?php
//require_once('Connections/bancoSolidario.php'); 
?>

<?php    


	
		function carregaComboEstados(){
		$sql = "SELECT * FROM tb_estados ORDER BY nomeEstado";
		$qr = mysql_query($sql);
		
		while($dados = mysql_fetch_assoc($qr)){
			echo '<option value="'.$dados["id"].'">'.$dados["nomeEstado"].'</option>';
		}
	}

?>
