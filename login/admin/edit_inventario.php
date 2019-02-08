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
  $updateSQL = sprintf("UPDATE inventario SET equipamento=%s, descricao=%s, `data`=%s, valor=%s, usuario=%s, destino=%s WHERE id=%s",
                       GetSQLValueString($_POST['equipamento'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['destino'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_inventario'>";
}

$colname_qr_cliente = "-1";
if (isset($_GET['id'])) {
  $colname_qr_cliente = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = sprintf("SELECT * FROM inventario WHERE id = %s", GetSQLValueString($colname_qr_cliente, "int"));
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_login = "SELECT * FROM usuarios";
$qr_login = mysql_query($query_qr_login, $Conexao) or die(mysql_error());
$row_qr_login = mysql_fetch_assoc($qr_login);
$totalRows_qr_login = mysql_num_rows($qr_login);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="38%" align="right" nowrap="nowrap"><div align="right">Id:</div></td>
      <td width="62%"><?php echo $row_qr_cliente['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Equipamento:</div></td>
      <td><input name="equipamento" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_cliente['equipamento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><div align="right">Descricao:</div></td>
      <td><label>
        <textarea name="descricao" cols="32" rows="3" class="imputTxt" id="descricao"><?php echo htmlentities($row_qr_cliente['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data:</div></td>
      <td><input name="data" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_cliente['data'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input name="valor" type="text" class="imputTxt" id="valor" onKeyPress="FormataValor(this.id, 10, event)" value="<?php echo htmlentities($row_qr_cliente['valor'], ENT_COMPAT, 'utf-8'); ?>" size="10"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Usuario:</div></td>
      <td><select name="usuario" class="imputTxt">
        <?php 
do {  
?>
        <option value="<?php echo $row_qr_login['login']?>" <?php if (!(strcmp($row_qr_login['login'], htmlentities($row_qr_cliente['usuario'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_qr_login['login']?></option>
        <?php
} while ($row_qr_login = mysql_fetch_assoc($qr_login));
?>
      </select>
        <input type="hidden" name="destino" value="<?php echo htmlentities($row_qr_cliente['destino'], ENT_COMPAT, 'utf-8'); ?>" size="32" />      </td>
    </tr>
    <tr> </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_cliente['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_cliente);

mysql_free_result($qr_login);
?>
