<?php require_once('Connections/Conexao.php'); ?>
<?php
$ip = getenv("REMOTE_ADDR");
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

$colname_qr_logados = "-1";
if (isset($_GET['ip'])) {
  $colname_qr_logados = $_GET['ip'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_logados = sprintf("SELECT * FROM logados WHERE ip = '$ip'", GetSQLValueString($colname_qr_logados, "text"));
$qr_logados = mysql_query($query_qr_logados, $Conexao) or die(mysql_error());
$row_qr_logados = mysql_fetch_assoc($qr_logados);
$totalRows_qr_logados = mysql_num_rows($qr_logados);

$colname_qr_cliente = "-1";
if (isset($_GET['ip'])) {
  $colname_qr_cliente = $_GET['ip'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = sprintf("SELECT * FROM usuarios WHERE ip = '$ip'", GetSQLValueString($colname_qr_cliente, "text"));
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);
?>
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
$logado = $row_qr_logados['ip'];
$maccli = $row_qr_cliente['mac'];
$ipcli = $row_qr_logados['ip'];
$macarp = trim(shell_exec("/usr/bin/sudo /usr/sbin/arp -n | grep $ip | awk '{print $3}' "));

if("$maccli" == "$macarp")
	{
	if($logado == "ip")
		{
		include "ok.php";
		}
		else
		{
		include "painel/plus/index.php";
		}
	
	}
	else
	{
	echo "<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width='200' border='0' align='center'>
  <tr>
    <td align='center'><div id='aviso'>
      <p>SEU COMPUTADOR NÃO ESTA CADASTRADO NO SISTEMA POR FAVOR ENTRE EM CONTATO COM O ADMINISTRADOR<br />
        FONE: (93) 8405-9966 </p>
    </div></td>
  </tr>
</table>";
	}
?>
<?php
mysql_free_result($qr_logados);

mysql_free_result($qr_cliente);
?>