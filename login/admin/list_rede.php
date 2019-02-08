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

$colname_qr_inernet = "-1";
if (isset($_GET['desc'])) {
  $colname_qr_inernet = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_inernet = "SELECT * FROM rede WHERE `desc` = 'internet'";
$qr_inernet = mysql_query($query_qr_inernet, $Conexao) or die(mysql_error());
$row_qr_inernet = mysql_fetch_assoc($qr_inernet);
$totalRows_qr_inernet = mysql_num_rows($qr_inernet);

$colname_Recordset1qr_local = "-1";
if (isset($_GET['desc'])) {
  $colname_Recordset1qr_local = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_local = "SELECT * FROM rede WHERE `desc` = 'local'";
$Recordset1qr_local = mysql_query($query_Recordset1qr_local, $Conexao) or die(mysql_error());
$row_Recordset1qr_local = mysql_fetch_assoc($Recordset1qr_local);
$totalRows_Recordset1qr_local = mysql_num_rows($Recordset1qr_local);

mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_vlan = "SELECT * FROM v_lan";
$Recordset1qr_vlan = mysql_query($query_Recordset1qr_vlan, $Conexao) or die(mysql_error());
$row_Recordset1qr_vlan = mysql_fetch_assoc($Recordset1qr_vlan);
$totalRows_Recordset1qr_vlan = mysql_num_rows($Recordset1qr_vlan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {
	color: #003300;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <th colspan="3" background="../imagens/message_toolbar_tile.gif">Configurações da Rede</th>
  </tr>
  <tr>
    <td colspan="3"><span class="style1">Internet</span></td>
  </tr>
  <tr>
    <td width="155">&nbsp;</td>
    <td colspan="2" rowspan="4" align="left"><?php do { ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="3%" align="right"><img src="../imagens/hardware.png" width="22" height="22" border="0" align="absmiddle" /></td>
            <td width="97%"><span class="style2"><?php echo $row_qr_inernet['eth']; ?></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>
              <?php 
	$rede1 = $row_qr_inernet['eth'];
	echo shell_exec ("sudo ifconfig $rede1 | grep inet ");
	?>
            </strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="?pg=del_rede&amp;id=<?php echo $row_qr_inernet['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" align="left" /> Remover</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="?pg=add_vlan"><img src="../imagens/Untitled-3.gif" alt="" width="12" height="12" border="0" align="absmiddle" /></a> <a href="?pg=add_rede">Declara</a></td>
          </tr>
                </table>
        <?php } while ($row_qr_inernet = mysql_fetch_assoc($qr_inernet)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><span class="style1">Rede Local</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="4" align="left"><?php do { ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="3%" align="right"><img src="../imagens/hardware.png" width="22" height="22" border="0" align="absmiddle" /></td>
            <td width="97%"><span class="style2"><?php echo $row_Recordset1qr_local['eth']; ?></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong><?php 
			$rede2 = $row_Recordset1qr_local['eth'];
			echo shell_exec ("sudo ifconfig $rede2 | grep inet ");
			?></strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="?pg=del_rede&amp;id=<?php echo $row_qr_inernet['id']; ?>"><img src="../imagens/botao_drop.png" alt="" width="16" height="16" border="0" align="left" /></a> <a href="?pg=del_rede&amp;id=<?php echo $row_Recordset1qr_local['id']; ?>">Remover</a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="?pg=add_vlan"><img src="../imagens/Untitled-3.gif" alt="" width="12" height="12" border="0" align="absmiddle" /></a> <a href="?pg=add_rede">Declara</a></td>
          </tr>
                </table>
        <?php } while ($row_Recordset1qr_local = mysql_fetch_assoc($Recordset1qr_local)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th colspan="3" background="../imagens/message_toolbar_tile.gif">Redes Virtuais</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"><span class="style1">Endereçamentos</span></td>
    <td><?php do { ?>
        <table width="333" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="23" align="center">&nbsp;</td>
            <td width="23" align="center">&nbsp;</td>
            <td width="23" align="center"><?php $idff = $row_Recordset1qr_vlan['id_eth']; 
			echo $idff;
			?></td>
            <td width="23" align="center"><img src="../imagens/agt_action_success.png" width="22" height="22" align="absmiddle" /></td>
            <td width="143" align="center" background="../imagens/bsar_laranja.jpg"><strong>
              <?php $vlan = $row_Recordset1qr_vlan['v_lan_ip'];
			echo $vlan;
			 ?>
            </strong></td>
            <td width="32" align="center"><a href="?pg=del_vlan&id=<?php echo $row_Recordset1qr_vlan['id']; ?>"><img src="../imagens/button_cancel.png" width="22" height="22" border="0" /></a></td>
            <td width="66" align="center"><img src="../imagens/cadeado.gif" width="22" height="22" /></td>
          </tr>
                </table>
        <?php } while ($row_Recordset1qr_vlan = mysql_fetch_assoc($Recordset1qr_vlan)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="?pg=add_vlan"><img src="../imagens/Untitled-3.gif" width="12" height="12" border="0" align="absmiddle" /> Cadastrar</a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_inernet);

mysql_free_result($Recordset1qr_local);

mysql_free_result($Recordset1qr_vlan);
?>
