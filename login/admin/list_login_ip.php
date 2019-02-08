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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_login_ip = "SELECT * FROM usuarios ORDER BY ip ASC";
$qr_login_ip = mysql_query($query_qr_login_ip, $Conexao) or die(mysql_error());
$row_qr_login_ip = mysql_fetch_assoc($qr_login_ip);
$totalRows_qr_login_ip = mysql_num_rows($qr_login_ip);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>	
<table width="100%" border="0" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <th colspan="9" bgcolor="#FF9900">Lista Rapida de Clientes</th>
  </tr>
  <tr align="center">
    <td width="2%" background="../imagens/message_toolbar_tile.gif"><strong>ID</strong></td>
    <td width="24%" background="../imagens/message_toolbar_tile.gif"><strong>Nome</strong></td>
    <td width="15%" background="../imagens/message_toolbar_tile.gif"><strong>IP</strong></td>
    <td width="6%" background="../imagens/message_toolbar_tile.gif"><strong>Situação</strong></td>
    <td width="5%" background="../imagens/message_toolbar_tile.gif">Estatus</td>
    <td colspan="4" background="../imagens/message_toolbar_tile.gif">Analice de Integridade de Cadastro</td>
  </tr>
  <?php do { ?>
    <tr class="tab1">
      <td align="center"><?php 
	$id =$row_qr_login_ip['id']; 
	echo $id;
	?></td>
      <td><strong><a href="?pg=edit_login4&id=<?php echo $row_qr_login_ip['id']; ?>"><?php echo $row_qr_login_ip['login']; ?></a></strong></td>
      <td><span class="style1"><?php echo $row_qr_login_ip['ip']; ?></span></td>
      <td align="center"><?php $situ = $row_qr_login_ip['situacao']; 
	  echo $situ;
	  ?></td>
      <td align="center"><?php 
		
		    $login22 = $row_qr_login_ip['login'];
			$sql = mysql_query("SELECT * FROM logados WHERE login='$login22 '");
			$total = mysql_num_rows($sql);
			if($total > 0){
			echo "<font color='green'><strong><img src='../imagens/agt_action_success.png' /></a>";
			} else {
			echo "";
			}
			?></td>
      <td width="9%"><?php 
	  $ip = $row_qr_login_ip['ip'];
	  $macarp = trim(shell_exec("/usr/bin/sudo /usr/sbin/arp -n | grep $ip | awk '{print $3}'")); 
	  echo $macarp;
	  ?></td>
      <td width="6%">
	  <?php 
	  $mcli = $row_qr_login_ip['mac'];
	  if ("$macarp" == "$mcli"){
	  echo "verdadeiro";
	  }
	  else {
	  echo "Falso";
	  }
	  ?>	  </td>
      <td width="12%"><?php echo $row_qr_login_ip['mac']; ?></td>
      <td width="21%">
<?
/**
$comando = "sudo arping -c 1 " . $ip;
$saida = shell_exec($comando);

echo "<br>"."Status:";
if ( ereg("Unicast reply",$saida) ) {
echo "<b>online</b></td>";
} else {
echo "<font color=red><b>não responde</b></font></td>";
}
*/

if ("$macarp" <> "0"){
echo "Online";
}
else {
echo "Off";
}

?></td>
    </tr>
    <?php } while ($row_qr_login_ip = mysql_fetch_assoc($qr_login_ip)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_login_ip);
?>
