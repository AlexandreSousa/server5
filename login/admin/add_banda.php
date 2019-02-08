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
  $insertSQL = sprintf("INSERT INTO banda (id_cbq, `desc`, banda_down, div_down, prio_down, banda_up, div_up, prio_up) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_cbq'], "text"),
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['banda_down'], "text"),
                       GetSQLValueString($_POST['div_down'], "text"),
                       GetSQLValueString($_POST['prio_down'], "text"),
                       GetSQLValueString($_POST['banda_up'], "text"),
                       GetSQLValueString($_POST['div_up'], "text"),
                       GetSQLValueString($_POST['prio_up'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_banda'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_banda = "SELECT * FROM banda";
$Recordset1qr_banda = mysql_query($query_Recordset1qr_banda, $Conexao) or die(mysql_error());
$row_Recordset1qr_banda = mysql_fetch_assoc($Recordset1qr_banda);
$totalRows_Recordset1qr_banda = mysql_num_rows($Recordset1qr_banda);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de Banda</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="40%" align="right" nowrap="nowrap">Id cbq:</td>
      <td width="60%"><span class="style1">
        <input type="hidden" name="id_cbq" value="<?php include 'randon.php' ?>" size="32" />
        <?php include 'randon.php' ?>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Desc:</td>
      <td><input type="text" name="desc" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda down:</td>
      <td><input type="text" name="banda_down" value="" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Div down:</td>
      <td><input type="text" name="div_down" value="" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prio_down:</td>
      <td><select name="prio_down">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>7</option>
        <option value="8" <?php if (!(strcmp(8, ""))) {echo "SELECTED";} ?>>8</option>
        <option value="9" <?php if (!(strcmp(9, ""))) {echo "SELECTED";} ?>>9</option>
        <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda up:</td>
      <td><input type="text" name="banda_up" value="" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Div up:</td>
      <td><input type="text" name="div_up" value="" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prio up:</td>
      <td><select name="prio_up">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>7</option>
        <option value="8" <?php if (!(strcmp(8, ""))) {echo "SELECTED";} ?>>8</option>
        <option value="9" <?php if (!(strcmp(9, ""))) {echo "SELECTED";} ?>>9</option>
        <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
      </select>      </td>
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
mysql_free_result($Recordset1qr_banda);
?>
