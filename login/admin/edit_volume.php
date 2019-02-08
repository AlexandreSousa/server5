<?php require_once('../Connections/Conexao.php'); ?>
<?php

$mdown = $_POST['down'];
$mup = $_POST['up'];


$mbitd = $mdown;
$download = $mbitd * 1024;
$download = $download * 1024;

$download;

$mbitu = $mup;
$upload = $mbitu * 1024;
$upload = $upload * 1024;
$upload;


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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE banwidth SET down=%s, up=%s, tipo=%s, mensal=%s, randon=%s WHERE id=%s",
                       GetSQLValueString( $download, "text"),
                       GetSQLValueString( $upload, "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['mensal'], "text"),
                       GetSQLValueString($_POST['randon'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=add_volume'>";
}

$colname_qr_volume = "-1";
if (isset($_GET['id'])) {
  $colname_qr_volume = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_volume = sprintf("SELECT * FROM banwidth WHERE id = %s", GetSQLValueString($colname_qr_volume, "int"));
$qr_volume = mysql_query($query_qr_volume, $Conexao) or die(mysql_error());
$row_qr_volume = mysql_fetch_assoc($qr_volume);
$totalRows_qr_volume = mysql_num_rows($qr_volume);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="35%" align="right" nowrap="nowrap">Id:</td>
      <td width="65%"><?php echo $row_qr_volume['id']; ?>
      <input type="hidden" name="mensal" value="<?php echo htmlentities($row_qr_volume['mensal'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <input type="hidden" name="randon" value="<?php echo htmlentities($row_qr_volume['randon'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td><input name="tipo" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_volume['tipo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Down:</td>
      <td><input name="down" type="text" class="imputTxt" value="<?php 
	  $dow =  $row_qr_volume['down'];
	  $mbitd = $dow;
	  $download = $mbitd / 1024;
	  $download = $download / 1024;
	  echo $download;
	   ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Up:</td>
      <td><input name="up" type="text" class="imputTxt" value="<?php 
	  $upp = $row_qr_volume['up']; 
	  
	  $mbitu = $upp;
	  $upload = $mbitu / 1024;
	  $upload = $upload / 1024;
 	  echo $upload;
	  
	  ?>" size="10" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1"value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_volume['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_volume);
?>
