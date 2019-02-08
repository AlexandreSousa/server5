<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../class/funcoes.php'); ?>
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
if (isset($_GET['login'])) {
  $colname_qr_user = $_GET['login'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_user = sprintf("SELECT * FROM sessao WHERE login = %s", GetSQLValueString($colname_qr_user, "text"));
$qr_user = mysql_query($query_qr_user, $Conexao) or die(mysql_error());
$row_qr_user = mysql_fetch_assoc($qr_user);
$totalRows_qr_user = mysql_num_rows($qr_user);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style3 {color: #FF0000; font-weight: bold; }
.style4 {color: #00FF00}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="5" align="center" background="../imagens/message_toolbar_tile.gif">Estatiscas de trafego</td>
  </tr>
  <tr>
    <th width="2%">&nbsp;</th>
    <th width="26%" align="left"><span class="style4">
      <?php 
	$login = $row_qr_user['login']; 
	echo $login;
	?>
    </span></th>
    <th width="21%">&nbsp;</th>
    <th width="25%">&nbsp;</th>
    <th width="26%">&nbsp;</th>
  </tr>
  <tr>
    <th>ID</th>
    <th>IP</th>
    <th>Data</th>
    <th align="left">DownLoad</th>
    <th align="left">UploAd</th>
  </tr>
  <?php do { ?>
    <tr>
      <td height="30"><?php 
	  $id = $row_qr_user['id'];
	  echo $id; 
	  ?></td>
      <td align="center"><?php echo $row_qr_user['ip']; ?></td>
      <td align="center"><?php echo $row_qr_user['data']; ?></td>
      <td align="left"><?php echo colores($row_qr_user['down'], 3); ?></td>
      <td align="left"><?php echo colores($row_qr_user['up'], 3); ?></td>
    </tr>
    <?php } while ($row_qr_user = mysql_fetch_assoc($qr_user)); ?>
    <tr>
      <td colspan="5" background="../imagens/toolbar_divider_vertical.gif">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>Total:</strong></td>
    <td><span class="style3"><?php

//$sql = mysql_query ("SELECT SUM(down) as down FROM sessao WHERE login = '$login"); 
//$sql = mysql_query ("select sum(down) as down from sessao group by down having login='$login'");
$sql2 = mysql_query ("SELECT sum(down) as down FROM sessao WHERE login = '$login'"); 
$linhas = mysql_num_rows($sql2);

for($i=0;$i<$linhas;$i++){
	
	$down =  mysql_result($sql2,$i,'down');

	
	echo colores($down, 3);
	}
	?>
    </span></td>
    <td><?php

$sql = mysql_query ("SELECT sum(down) as down,sum(up) as up FROM sessao WHERE login = '$login'"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
	$up =  mysql_result($sql,$i,'up');
	

	
	echo colores($up, 3);
	}
	?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_user);
?>
