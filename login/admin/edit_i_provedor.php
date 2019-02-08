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
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_i_provedor'>";
}

$colname_qr_inventario = "-1";
if (isset($_GET['id'])) {
  $colname_qr_inventario = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_inventario = sprintf("SELECT * FROM inventario WHERE id = %s", GetSQLValueString($colname_qr_inventario, "int"));
$qr_inventario = mysql_query($query_qr_inventario, $Conexao) or die(mysql_error());
$row_qr_inventario = mysql_fetch_assoc($qr_inventario);
$totalRows_qr_inventario = mysql_num_rows($qr_inventario);
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
      <td width="33%" align="right" nowrap="nowrap"><div align="right">Equipamento:</div></td>
      <td width="67%"><input type="text" name="equipamento" value="<?php echo htmlentities($row_qr_inventario['equipamento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="middle"><div align="right">Descricao:</div></td>
      <td><textarea name="descricao" cols="32" rows="3"><?php echo htmlentities($row_qr_inventario['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data:</div></td>
      <td><input type="text" name="data" value="<?php echo htmlentities($row_qr_inventario['data'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input type="text" name="valor" value="<?php echo htmlentities($row_qr_inventario['valor'], ENT_COMPAT, 'utf-8'); ?>" onKeyPress="FormataValor(this.id, 10, event)" id="valor" size="10" />
      <input type="hidden" name="usuario" value="<?php echo htmlentities($row_qr_inventario['usuario'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <input type="hidden" name="destino" value="<?php echo htmlentities($row_qr_inventario['destino'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_inventario['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_inventario);
?>
