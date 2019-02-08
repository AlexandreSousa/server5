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
  $updateSQL = sprintf("UPDATE banda SET `desc`=%s, banda_down=%s, div_down=%s, prio_down=%s, banda_up=%s, div_up=%s, prio_up=%s WHERE id=%s",
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['banda_down'], "text"),
                       GetSQLValueString($_POST['div_down'], "text"),
                       GetSQLValueString($_POST['prio_down'], "text"),
                       GetSQLValueString($_POST['banda_up'], "text"),
                       GetSQLValueString($_POST['div_up'], "text"),
                       GetSQLValueString($_POST['prio_up'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_banda'>";
}

$colname_qr_edit_cliente = "-1";
if (isset($_GET['id'])) {
  $colname_qr_edit_cliente = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_edit_cliente = sprintf("SELECT * FROM banda WHERE id = %s", GetSQLValueString($colname_qr_edit_cliente, "int"));
$qr_edit_cliente = mysql_query($query_qr_edit_cliente, $Conexao) or die(mysql_error());
$row_qr_edit_cliente = mysql_fetch_assoc($qr_edit_cliente);
$totalRows_qr_edit_cliente = mysql_num_rows($qr_edit_cliente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Editar Banda</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="41%" align="right" nowrap="nowrap">Id:</td>
      <td width="59%"><?php echo $row_qr_edit_cliente['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Desc:</td>
      <td><input type="text" name="desc" value="<?php echo htmlentities($row_qr_edit_cliente['desc'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda_down:</td>
      <td><input type="text" name="banda_down" value="<?php echo htmlentities($row_qr_edit_cliente['banda_down'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Div_down:</td>
      <td><input type="text" name="div_down" value="<?php echo htmlentities($row_qr_edit_cliente['div_down'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prio_down:</td>
      <td><select name="prio_down">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>7</option>
        <option value="8" <?php if (!(strcmp(8, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>8</option>
        <option value="9" <?php if (!(strcmp(9, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>9</option>
        <option value="10" <?php if (!(strcmp(10, htmlentities($row_qr_edit_cliente['prio_down'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>10</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda_up:</td>
      <td><input type="text" name="banda_up" value="<?php echo htmlentities($row_qr_edit_cliente['banda_up'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Div_up:</td>
      <td><input type="text" name="div_up" value="<?php echo htmlentities($row_qr_edit_cliente['div_up'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prio_up:</td>
      <td><select name="prio_up">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>7</option>
        <option value="8" <?php if (!(strcmp(8, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>8</option>
        <option value="9" <?php if (!(strcmp(9, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>9</option>
        <option value="10" <?php if (!(strcmp(10, htmlentities($row_qr_edit_cliente['prio_up'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>10</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar Dados" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_edit_cliente['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_edit_cliente);
?>
