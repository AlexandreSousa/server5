<?php //require_once('Connections/bancoSolidario.php');
include ('../Connections/Conexao.php');
 ?>

<?php 
$estado = $_POST['mensal'];

	if($estado == 'nao')
			 {
			 srand((double)microtime()*1000000);
			$numero = rand(100000,999999);
			
			$randon =  $numero;
            echo '<option value="'.$randon.'">'.$randon.'</option>';
			 }else
			 {
			 echo '<option value="0">.......</option>';
			 }


?>