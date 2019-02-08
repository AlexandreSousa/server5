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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO rede (`desc`, eth) VALUES (%s, %s)",
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['eth'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_rede'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_rede = "SELECT * FROM rede";
$qr_rede = mysql_query($query_qr_rede, $Conexao) or die(mysql_error());
$row_qr_rede = mysql_fetch_assoc($qr_rede);
$totalRows_qr_rede = mysql_num_rows($qr_rede);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de Rede</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="48%" align="right" nowrap="nowrap">Desc:</td>
      <td width="52%"><select name="desc">
        <option value="internet" <?php if (!(strcmp("internet", ""))) {echo "SELECTED";} ?>>Rede Internet</option>
        <option value="local" <?php if (!(strcmp("local", ""))) {echo "SELECTED";} ?>>Rede Local</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome da Rede:</td>
      <td><input type="text" name="eth" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Gravar Dados" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_rede);
?>
