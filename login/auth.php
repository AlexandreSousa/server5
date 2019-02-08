<?php  require_once('Connections/Conexao.php'); ?>
<?php include "class/data_class.php"; ?>
<?php $data = "$ano-$mes-$dia"; ?>
<style type="text/css">
<!--
#aviso {
	background-color: #CCCCCC;
}
#aviso {
	width: 400px;
	height: 100px;
}
#aviso {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
#aviso {
	text-align: center;
}
#aviso {
	border-top-style: dotted;
	border-right-style: dotted;
	border-bottom-style: dotted;
	border-left-style: dotted;
}
#aviso {
	vertical-align: top;
}
#aviso {
	color: #006699;
}
-->
</style>
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
?>
<?php  require_once('config.php'); ?>
<?php
session_start();
$colname_RSUsuario = "1";
if (isset($_POST['login'])) {
  $colname_RSUsuario = (get_magic_quotes_gpc()) ? $_POST['login'] : addslashes($_POST['login']);
}
mysql_select_db($database_Conexao, $Conexao);
$query_RSUsuario = sprintf("SELECT login, senha FROM usuarios WHERE login = '%s'", $colname_RSUsuario);
$RSUsuario = mysql_query($query_RSUsuario, $Conexao) or die(mysql_error());
$row_RSUsuario = mysql_fetch_assoc($RSUsuario);
$totalRows_RSUsuario = mysql_num_rows($RSUsuario);

$colname_RSMaclist = "1";
if (isset($_POST['login'])) {
  $colname_RSMaclist = (get_magic_quotes_gpc()) ? $_POST['login'] : addslashes($_POST['login']);
}
mysql_select_db($database_Conexao, $Conexao);
$query_RSMaclist = sprintf("SELECT situacao, mac, ip, login FROM usuarios WHERE login = '%s'", $colname_RSMaclist);
$RSMaclist = mysql_query($query_RSMaclist, $Conexao) or die(mysql_error());
$row_RSMaclist = mysql_fetch_assoc($RSMaclist);
$totalRows_RSMaclist = mysql_num_rows($RSMaclist);



// Pega os dados do Formulario de Login
$login = $_POST['login'];
$senha = $_POST['senha'];
$site = $_POST['site'];

$_SESSION['mmusrname'] = $login;

$colname_qr_ids_pega = "-1";
if (isset($_GET['login'])) {
  $colname_qr_ids_pega = $_GET['login'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_ids_pega = sprintf("SELECT * FROM usuarios WHERE login = '$login'", GetSQLValueString($colname_qr_ids_pega, "text"));
$qr_ids_pega = mysql_query($query_qr_ids_pega, $Conexao) or die(mysql_error());
$row_qr_ids_pega = mysql_fetch_assoc($qr_ids_pega);
$totalRows_qr_ids_pega = mysql_num_rows($qr_ids_pega);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_financeiro = "SELECT * FROM f_contas_receber WHERE f_contas_receber.vencimento <= '$data' AND UserName = '$login' AND f_contas_receber.status = 'aberto'";
$qr_financeiro = mysql_query($query_qr_financeiro, $Conexao) or die(mysql_error());
$row_qr_financeiro = mysql_fetch_assoc($qr_financeiro);
$totalRows_qr_financeiro = mysql_num_rows($qr_financeiro);



//Pega id do Clinte
$id = $row_qr_ids_pega['id'];

// Pega o IP do Cliente 
echo $ip = $_SERVER['REMOTE_ADDR']; 

// Pega o MAC do cliente
$mac = $row_RSMaclist['mac'];

// Pega o Mac Address da tabela ARP do servidor
echo $macarp = trim(shell_exec("/usr/bin/sudo /usr/sbin/arp -n | grep $ip | awk '{print $3}' 2>&1 1> /dev/null"));

// Data e hora
$data = date("d.m.y");
$hora = date("H:i:s");
$dlog= date("Y-m-d");

//Gera log
$logfile = "/var/www/server/logs/weblogin.log.php";
$abrir = fopen($logfile, "a");
include ('regras_auth.php');
/*

$cliente_f = $row_qr_ids_pega['cliente_f'];
//Verificar Financeiro

if(cobra == "$cliente_f"){
echo "Pagamento Pendente";
echo "<br />"; 
$status = $row_qr_financeiro['status'];

	if(aberto == "$status"){
	echo "Pendencias";
		include ('regras_auth.php');
	}else{
		include ('regras_auth.php');
  }

}elseif(bloquear == "$cliente_f"){
$status = $row_qr_financeiro['status'];
if(aberto == "$status"){
$sql = ("SELECT * FROM f_aviso");
$query = mysql_query($sql);
while($res = mysql_fetch_array($query)){
$aviso = $res['aviso'];

echo "<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width='200' border='0' align='center'>
  <tr>
    <td align='center'><div id='aviso'>
      <p>$aviso<br />
    </div></td>
  </tr>
</table>";
        }   
	}else{
		include ('regras_auth.php');
  }

}

*/

mysql_free_result($RSUsuario);
mysql_free_result($RSMaclist);

mysql_free_result($qr_ids_pega);

mysql_free_result($qr_financeiro);
?>
