<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../class/funcoes.php'); ?>
<?php
$data = date("d/m/Y");
$hora = date("H:i:s");

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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td width="61%" background="../imagens/message_toolbar_tile.gif"><strong class="style2">Estamos com <?php echo $totalRows_qr_logados ?> Usuários Conectados</strong></td>
    <td width="39%" background="../imagens/message_toolbar_tile.gif" class="style2"><strong>Hoje é <?php echo $data; ?> e <?php echo $hora; ?> Horas</strong></td>
  </tr>
</table>
<table id="tabela_exemplo"  class="tab1" width="100%" border="0">
  <tr class="teste">
    <th ><span class="style2">HL</span></th>
    <th><span class="style2">ID</span></th>
    <th align="center"><span class="style2">IP</span></th>
    <th align="center"><span class="style2">MAC</span></th>
    <th align="center"><span class="style2">USER</span></th>
    <th align="center"><span class="style2">SENHA</span></th>
    <th align="center">Down</th>
    <th align="center">Up</th>
    <th align="center"><span class="style2">DESLOGA</span></th>
    <th align="center"><a href="?pg=logados">
      <meta http-equiv='Refresh' content='5;URL=?pg=logados' />
      <img src="../imagens/ajaxload.gif" width="16" height="16" border="0" /></a></th>
  </tr>
  <?php do { ?>
  <tr class="tab1">
    <td width="3%"><a href="?pg=livrar&amp;id=<?php echo $row_qr_logados['id_cliente']; ?>"><img src="../imagens/agt_action_success.png" width="22" height="22" border="0" /></a></td>
    <td width="2%"><?php $idss = $row_qr_logados['id'];
	  echo $idss; ?></td>
    <td width="16%" align="center"><?php echo $row_qr_logados['ip']; ?></td>
    <td width="22%" align="center"><?php echo $row_qr_logados['mac']; ?></td>
    <td width="13%"><a href="?pg=edit_login2&amp;id=<?php echo $row_qr_logados['id_cliente']; ?>"><?php echo $row_qr_logados['login']; ?></a></td>
    <td width="13%"><?php echo $row_qr_logados['senha']; ?></td>
    <td width="9%" align="center"><?php $down = $row_qr_logados['down'];
	  echo colores ($down, 3);
	   ?></td>
    <td width="10%" align="center"><?php $up = $row_qr_logados['up']; 
	  echo colores ($up, 3 );
	  ?></td>
    <td width="9%" align="center"><a href="?pg=desloga&amp;id_cliente=<?php echo $row_qr_logados['id_cliente']; ?>"><img src="../imagens/button_cancel.png" width="22" height="22" border="0" /></a></td>
    <td width="3%" align="center"><a href="?pg=report_user&amp;login=<?php echo $row_qr_logados['login']; ?>"><img src="../imagens/kspread_ksp.png" width="22" height="22" border="0" /></a></td>
  </tr>
  <?php } while ($row_qr_logados = mysql_fetch_assoc($qr_logados)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_logados);
?>
