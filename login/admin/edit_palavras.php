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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE palavresproibidas SET palavra=%s WHERE id=%s",
                       GetSQLValueString($_POST['palavra'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
   echo "<meta http-equiv='refresh' content='0;URL=?pg=add_palavras'>";
   include "proibidos_sql.php";
}

$colname_qr_ed_palavras = "-1";
if (isset($_GET['id'])) {
  $colname_qr_ed_palavras = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_ed_palavras = sprintf("SELECT * FROM palavresproibidas WHERE id = %s", GetSQLValueString($colname_qr_ed_palavras, "int"));
$qr_ed_palavras = mysql_query($query_qr_ed_palavras, $Conexao) or die(mysql_error());
$row_qr_ed_palavras = mysql_fetch_assoc($qr_ed_palavras);
$totalRows_qr_ed_palavras = mysql_num_rows($qr_ed_palavras);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
.style2 {	font-size: 12px;
	color: #FF0000;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td align="center" background="../imagens/message_toolbar_tile.gif"><span class="style2"><span class="style1">Cadastr de Sites Proibidos</span></span></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id:</td>
      <td><?php echo $row_qr_ed_palavras['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Palavra:</td>
      <td><input type="text" name="palavra" value="<?php echo htmlentities($row_qr_ed_palavras['palavra'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Regravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_ed_palavras['id']; ?>" />
</form>
</body>
</html>
<?php
mysql_free_result($qr_ed_palavras);
?>
