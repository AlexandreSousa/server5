<?php require_once('Connections/Conexao.php'); ?>
<?php require_once('config.php'); ?>
 <?php
$ipcapture = getenv("REMOTE_ADDR");
echo $ipcapture;
 ?>
 <?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_qr_user = "-1";
if (isset($_GET['ip'])) {
  $colname_qr_user = $_GET['ip'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_user = sprintf("SELECT * FROM usuarios WHERE ip = '192.168.25.2'", GetSQLValueString($colname_qr_user, "text"));
$qr_user = mysql_query($query_qr_user, $Conexao) or die(mysql_error());
$row_qr_user = mysql_fetch_assoc($qr_user);
$totalRows_qr_user = mysql_num_rows($qr_user);

$idcliente = $row_qr_user['id'];

$colname_qr_logados = "-1";
if (isset($_GET['id_cliente'])) {
  $colname_qr_logados = $_GET['id_cliente'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_logados = sprintf("SELECT * FROM logados WHERE id_cliente = '$idcliente'", GetSQLValueString($colname_qr_logados, "text"));
$qr_logados = mysql_query($query_qr_logados, $Conexao) or die(mysql_error());
$row_qr_logados = mysql_fetch_assoc($qr_logados);
$totalRows_qr_logados = mysql_num_rows($qr_logados);

$ulogin = $row_qr_logados['id_cliente'];

$colname_qr_serial = "-1";
if (isset($_GET['login_u'])) {
  $colname_qr_serial = $_GET['login_u'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_serial = sprintf("SELECT * FROM esec WHERE login_u = '$ulogin'", GetSQLValueString($colname_qr_serial, "text"));
$qr_serial = mysql_query($query_qr_serial, $Conexao) or die(mysql_error());
$row_qr_serial = mysql_fetch_assoc($qr_serial);
$totalRows_qr_serial = mysql_num_rows($qr_serial);


$ipcapture = getenv("REMOTE_ADDR");
 
?>
<p>
<?php

echo $tip_auth = $row_qr_user['id_auth'];

if (1 == $tip_auth) {

//REGEITAR O DISCADOR APAGANDO OS DADOS LOGADOS ZERANDO AS CONFIGURAÇÕES E REDIRECIONANDO PARA A PAGINA DE LOGIN PADRÃO
echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    echo "Rejeitar dicador Apresenta Login WEB";
} elseif (2 == $tip_auth ) {
 //Usando o discador mais mandando logar onlinea
	echo "Recurcos não disponivel";
} elseif (3 == $tip_auth ) {
//Discador Liberar Internet apos a checagen
 echo "Liberando Internet Aguarde Um momento";
 echo "<br>";
$serial = $row_qr_logados['hdalfa'];
$serial2 = $row_qr_serial['hdalfa'];
if ($serial == $serial2) {
echo "Primeira etapa";
echo "<br>";
$chk1 = $row_qr_logados['serial'];
$chk2 = $row_qr_serial['serial'];
	
	
	if($chk1 == $chk2){
	echo "serial Aceio";
	}
	else {
	echo "Error 590";
	echo "Ocorreu um problema ao acessar a internet Por favor entre em conato com o suporte tecnico";
	}
}
else {
echo "Problema de Configuração Contacte o Suporte Tecino";
}

   
}


?>
</p>
<table width="200" border="1">
  <tr>
    <td>fjsakdfkjasd</td>
    <td><?php echo $row_qr_logados['login']; ?></td>
  </tr>
  <tr>
    <td>TAbela 2</td>
    <td><?php echo $row_qr_serial['ip']; ?></td>
  </tr>
</table>
<p>
  <?php
mysql_free_result($qr_logados);

mysql_free_result($qr_serial);

mysql_free_result($qr_user);
?>
</p>
