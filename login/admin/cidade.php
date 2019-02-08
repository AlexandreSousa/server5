<?php //require_once('Connections/bancoSolidario.php');
include ('../Connections/Conexao.php');
 ?>

<?php 
$estado = $_POST['mensal'];

//echo '<option value="0">'.$minha_cidade.'</option>';


echo '<option value="0">Selecione uma cidade</option>';

$randon = $estado;
echo '<option value="'.$randon.'">'.$randon.'</option>';
?>