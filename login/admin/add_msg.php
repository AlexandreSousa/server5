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
  $updateSQL = sprintf("UPDATE usuarios SET msg=%s WHERE id=%s",
                       GetSQLValueString($_POST['msg'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  $idss = $_POST['id'];
  echo "<meta http-equiv='refresh' content='0;URL=?pg=edit_login&id=$idss'>";
}

$colname_qr_msg = "-1";
if (isset($_GET['id'])) {
  $colname_qr_msg = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_msg = sprintf("SELECT * FROM usuarios WHERE id = %s", GetSQLValueString($colname_qr_msg, "int"));
$qr_msg = mysql_query($query_qr_msg, $Conexao) or die(mysql_error());
$row_qr_msg = mysql_fetch_assoc($qr_msg);
$totalRows_qr_msg = mysql_num_rows($qr_msg);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
      <tr valign="baseline">
        <td colspan="3" align="right" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif">&nbsp;</td>
      </tr>
    <tr valign="baseline">
      <td width="321" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="286" align="right" nowrap="nowrap"><textarea name="msg" id="msg" cols="45" rows="5"><?php echo htmlentities($row_qr_msg['msg'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
      <td width="318" align="left" valign="top" nowrap="nowrap"><span class="style2">
        <input name="image2" type="image" / value="Insert record" src="../imagens/3floppy_unmount.png" />
        <br />
        [Salvar]
      </span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_msg['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_msg);
?>
