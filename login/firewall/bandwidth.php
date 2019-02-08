<?php require_once('../Connections/Conexao.php'); ?>
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

$colname_qr_iface_local = "-1";
if (isset($_GET['desc'])) {
  $colname_qr_iface_local = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_iface_local = sprintf("SELECT * FROM rede WHERE `desc` = 'local'", GetSQLValueString($colname_qr_iface_local, "text"));
$qr_iface_local = mysql_query($query_qr_iface_local, $Conexao) or die(mysql_error());
$row_qr_iface_local = mysql_fetch_assoc($qr_iface_local);
$totalRows_qr_iface_local = mysql_num_rows($qr_iface_local);
?>
<?php
//Gera as regra do iptable para monitoramento de trafego de rede
$rede = $row_qr_iface_local['eth'];
shell_exec("sudo iptables -N control 2>&1 1> /dev/null");
shell_exec("sudo iptables -A INPUT -i $rede -j control 2>&1 1> /dev/null");
shell_exec("sudo iptables -A OUTPUT -o $rede -j control 2>&1 1> /dev/null");
shell_exec("sudo iptables-save 2>&1 1> /dev/null");
?>

<table width="200" border="1">
  <tr>
    <td><?php echo $row_qr_iface_local['eth']; ?></td>
  </tr>
</table>
<?php
mysql_free_result($qr_iface_local);
?>