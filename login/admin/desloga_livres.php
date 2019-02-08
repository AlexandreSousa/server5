<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>
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

if ((isset($_GET['id_cliente'])) && ($_GET['id_cliente'] != "")) {
  $deleteSQL = sprintf("DELETE FROM hlivres WHERE id_cliente=%s",
                       GetSQLValueString($_GET['id_cliente'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($deleteSQL, $Conexao) or die(mysql_error());

 $id_cliente = $_GET[id_cliente];
echo $id_cliente;
mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = sprintf("SELECT * FROM usuarios WHERE id = $id_cliente", GetSQLValueString($colname_qr_cliente, "int"));
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);

//Regra para deslogar a negada
$ip = $row_qr_cliente['ip'];

//Removendo regras de navegação e mandando o cliente de volta para a pagina de login
shell_exec("sudo iptables -t nat -D PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
shell_exec("sudo iptables -t nat -D POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
shell_exec("sudo iptables -D FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");

//Removendo a regra de monitoramento de trafego
shell_exec("sudo iptables -D control -d $ip 2>&1 1> /dev/null");
shell_exec("sudo iptables -D control -s $ip 2>&1 1> /dev/null");


//Apagando arquivos de trafego referente 
shell_exec("sudo rm -rf /var/www/server/banda/$ip-up");
shell_exec("sudo rm -rf /var/www/server/banda/$ip-down");
shell_exec("/var/www/server/banda/$ip-bandwidthCurrent");
//Removendo o proxy
shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid 2>&1 1> /dev/null");


 echo "<meta http-equiv='refresh' content='0;URL=?pg=h_livres'>"; 
}

$colname_qr_desloga = "-1";
if (isset($_GET['id_cliente'])) {
  $colname_qr_desloga = $_GET['id_cliente'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_desloga = sprintf("SELECT * FROM hlivres WHERE id_cliente = %s", GetSQLValueString($colname_qr_desloga, "int"));
$qr_desloga = mysql_query($query_qr_desloga, $Conexao) or die(mysql_error());
$row_qr_desloga = mysql_fetch_assoc($qr_desloga);
$totalRows_qr_desloga = mysql_num_rows($qr_desloga);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($qr_desloga);

mysql_free_result($qr_cliente);
?>
