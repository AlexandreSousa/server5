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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_hlivres = "SELECT * FROM hlivres";
$qr_hlivres = mysql_query($query_qr_hlivres, $Conexao) or die(mysql_error());
$row_qr_hlivres = mysql_fetch_assoc($qr_hlivres);
$totalRows_qr_hlivres = mysql_num_rows($qr_hlivres);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <th width="17" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999">R</th>
    <th width="17" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">ID</span></th>
    <th width="123" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">IP</span></th>
    <th width="148" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">MAC</span></th>
    <th width="122" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">USER</span></th>
    <th width="122" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">SENHA</span></th>
    <th width="118" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999">Down</th>
    <th width="113" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999">Up</th>
    <th width="63" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><span class="style2">DESLOGA</span></th>
    <th colspan="2" background="../imagens/message_toolbar_tile.gif" bgcolor="#009999"><a href="?pg=h_livres">
      <meta http-equiv='Refresh' content='5;URL=?pg=h_livres' />
      <img src="../imagens/update_p.jpg" width="21" height="18" border="0" /></a></th>
  </tr>
  <?php do { ?>
  <tr>
    <th align="center" bgcolor="#999999"><img src="../imagens/botao_drop.png" width="16" height="16" /></th>
    <th align="center" bgcolor="#999999"><?php $idss = $row_qr_hlivres['id'];
	  echo $idss; ?></th>
    <td align="center"><?php echo $row_qr_hlivres['ip']; ?></td>
    <td align="center"><?php echo $row_qr_hlivres['mac']; ?></td>
    <td align="left"><a href="?pg=edit_login3&amp;id=<?php echo $row_qr_hlivres['id_cliente']; ?>"><?php echo $row_qr_hlivres['login']; ?></a></td>
    <td align="left"><?php echo $row_qr_hlivres['senha']; ?></td>
    <td align="center"><?php $down = $row_qr_hlivres['down'];
	  echo colores ($down, 3);
	   ?></td>
    <td align="center"><?php $up = $row_qr_hlivres['up']; 
	  echo colores ($up, 3 );
	  ?></td>
    <td align="center"><a href="?pg=desloga_livres&amp;id_cliente=<?php echo $row_qr_hlivres['id_cliente']; ?>"><img src="../imagens/button_cancel.png" width="22" height="22" border="0" /></a></td>
    <td width="10" align="center">&nbsp;</td>
    <td width="37" align="center"><a href="?pg=report_user&amp;login=<?php echo $row_qr_hlivres['login']; ?>"><img src="../imagens/kspread_ksp.png" width="22" height="22" border="0" /></a></td>
  </tr>
  <?php } while ($row_qr_hlivres = mysql_fetch_assoc($qr_hlivres)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_hlivres);
?>
