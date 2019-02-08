<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>

<?php
 $id = $_GET[id];

$sql = mysql_query ("SELECT * FROM logados WHERE id_cliente = '$id'"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++) {
	$id =  mysql_result($sql,$i,'id');
    $id_cliente =  mysql_result($sql,$i,'id_cliente');
	$ip =  mysql_result($sql,$i,'ip');
	$proxy =  mysql_result($sql,$i,'proxy');
	$mac =  mysql_result($sql,$i,'mac');
	$id_auth =  mysql_result($sql,$i,'id_auth');
	$login =  mysql_result($sql,$i,'login');
	$senha =  mysql_result($sql,$i,'senha');
	$down =  mysql_result($sql,$i,'down');
	$up =  mysql_result($sql,$i,'up');
	$esec =  mysql_result($sql,$i,'esec');
	$hdalfa =  mysql_result($sql,$i,'hdalfa');
	$serial =  mysql_result($sql,$i,'serial');
	$chave =  mysql_result($sql,$i,'chave');
	$randon =  mysql_result($sql,$i,'randon');
	
	echo "ksahdklasd";

$sql3 = "INSERT INTO hlivres (ip,id_cliente,proxy,mac,login,senha) VALUES ('$ip', '$id_cliente','$proxy','$mac', '$login', '$senha')";
$query = mysql_query($sql3) or die("erro:".mysql_error());

$sql4 = "DELETE FROM logados WHERE id_cliente = '$id_cliente' LIMIT 1;";
 $query = mysql_query($sql4) or die("erro:".mysql_error());
 
  echo "<meta http-equiv='refresh' content='0;URL=?pg=h_livres'>"; 
     }

?>