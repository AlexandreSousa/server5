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



mysql_select_db($database_Conexao, $Conexao);
$query_qr_logados = "SELECT * FROM logados";
$qr_logados = mysql_query($query_qr_logados, $Conexao) or die(mysql_error());
$row_qr_logados = mysql_fetch_assoc($qr_logados);
$totalRows_qr_logados = mysql_num_rows($qr_logados);

$colname_qr_desloga = "-1";
if (isset($_GET['id'])) {
  $colname_qr_desloga = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_desloga = sprintf("SELECT * FROM deslogar_metodo WHERE id = '1'", GetSQLValueString($colname_qr_desloga, "int"));
$qr_desloga = mysql_query($query_qr_desloga, $Conexao) or die(mysql_error());
$row_qr_desloga = mysql_fetch_assoc($qr_desloga);
$totalRows_qr_desloga = mysql_num_rows($qr_desloga);

$colname_qr_interface = "-1";
if (isset($_GET['desc'])) {
  $colname_qr_interface = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_interface = sprintf("SELECT * FROM rede WHERE `desc` = 'local'", GetSQLValueString($colname_qr_interface, "text"));
$qr_interface = mysql_query($query_qr_interface, $Conexao) or die(mysql_error());
$row_qr_interface = mysql_fetch_assoc($qr_interface);
$totalRows_qr_interface = mysql_num_rows($qr_interface);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="0">
  <?php do { ?>
    <tr>
      <td width="18%"><?php echo $row_qr_logados['ip']; ?></td>
      <td width="82%"><p>
          <?php
$metodo = $row_qr_desloga['metodo'];

if (ping == $metodo){

echo "Deslogar por PING";



$ip = $row_qr_logados['ip'];
$pings = $row_qr_desloga['pings'];

$comando = "sudo ping -c $pings  " . $ip;
$saida = shell_exec($comando);
//Unicast reply
echo "<br>"."Status:";
if ( ereg("bytes from",$saida) ) {
echo "<b>online</b></td>";
} else {
echo "<font color=red><b>não responde deslogar</b></font></td>";

 $ip;
echo $id = $row_qr_logados['id'];



//Removendo regras de navegação e mandando o cliente de volta para a pagina de login
shell_exec("sudo iptables -t nat -D PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
shell_exec("sudo iptables -t nat -D POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
shell_exec("sudo iptables -D FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");

//Removendo regra de MAX x IP
    shell_exec("sudo iptables -D FORWARD -d 0/0 -s $ip -m mac --mac-source $mac -j ACCEPT 2>&1 1> /dev/nul");
	shell_exec("sudo iptables -D FORWARD -s 0/0 -d $ip -mstate --state ESTABLISHED,RELATED -j ACCEPT 2>&1 1> /dev/nul");
	shell_exec("sudo iptables -t nat -D POSTROUTING -s $ip -d 0/0 -j SNAT --to $servidor 2>&1 1> /dev/nul");

//Removendo a regra de monitoramento de trafego
shell_exec("sudo iptables -D control -d $ip 2>&1 1> /dev/null");
shell_exec("sudo iptables -D control -s $ip 2>&1 1> /dev/null");


//Apagando arquivos de trafego referente 
shell_exec("sudo rm -rf /var/www/server/banda/$ip-up");
shell_exec("sudo rm -rf /var/www/server/banda/$ip-down");
shell_exec("/var/www/server/banda/$ip-bandwidthCurrent");
//Removendo o proxy
shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid 2>&1 1> /dev/null");

$sql = "DELETE FROM logados WHERE id = '$id'";
$resultado = mysql_query($sql) or die (mysql_error());

}


}
else{

echo "Deslogar por ARPING";

echo $inface = $row_qr_interface['eth'];

$ip = $row_qr_logados['ip'];

$pings = $row_qr_desloga['pings'];

$comando = "sudo arping -c $pings -I $inface " . $ip;
$saida = shell_exec($comando);
//Unicast reply
echo "<br>"."Status:";
if ( ereg("Unicast reply",$saida) ) {
echo "<b>online</b></td>";
} else {
echo "<font color=red><b>não responde deslogar</b></font></td>";

echo $ip;
echo $id = $row_qr_logados['id'];


//Removendo regras de navegação e mandando o cliente de volta para a pagina de login
shell_exec("sudo iptables -t nat -D PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
shell_exec("sudo iptables -t nat -D POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
shell_exec("sudo iptables -D FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");

//Removendo regra de MAX x IP
    shell_exec("sudo iptables -D FORWARD -d 0/0 -s $ip -m mac --mac-source $mac -j ACCEPT 2>&1 1> /dev/nul");
	shell_exec("sudo iptables -D FORWARD -s 0/0 -d $ip -mstate --state ESTABLISHED,RELATED -j ACCEPT 2>&1 1> /dev/nul");
	shell_exec("sudo iptables -t nat -D POSTROUTING -s $ip -d 0/0 -j SNAT --to $servidor 2>&1 1> /dev/nul");

//Removendo a regra de monitoramento de trafego
shell_exec("sudo iptables -D control -d $ip 2>&1 1> /dev/null");
shell_exec("sudo iptables -D control -s $ip 2>&1 1> /dev/null");


//Apagando arquivos de trafego referente 
shell_exec("sudo rm -rf /var/www/server/banda/$ip-up");
shell_exec("sudo rm -rf /var/www/server/banda/$ip-down");
shell_exec("/var/www/server/banda/$ip-bandwidthCurrent");
//Removendo o proxy
shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid 2>&1 1> /dev/null");

shell_exec("sudo 1 >> /var/www/server/login/derrubada.sh");

$sql = "DELETE FROM logados WHERE id = '$id'";
$resultado = mysql_query($sql) or die (mysql_error());

}


}





?>
            </p></td>
    </tr>
    <?php } while ($row_qr_logados = mysql_fetch_assoc($qr_logados)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_logados);

mysql_free_result($qr_desloga);

mysql_free_result($qr_interface);
?>
