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
  $updateSQL = sprintf("UPDATE login SET nome=%s, senha=%s, situacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
					   GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
    echo "<meta http-equiv='refresh' content='0;URL=?pg=list_admin'>";
}

$colname_qr_admin = "-1";
if (isset($_GET['id'])) {
  $colname_qr_admin = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_admin = sprintf("SELECT * FROM login WHERE id = %s", GetSQLValueString($colname_qr_admin, "int"));
$qr_admin = mysql_query($query_qr_admin, $Conexao) or die(mysql_error());
$row_qr_admin = mysql_fetch_assoc($qr_admin);
$totalRows_qr_admin = mysql_num_rows($qr_admin);
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
      <td width="35%" align="right" nowrap="nowrap"><div align="right">Id:</div></td>
      <td width="65%"><div align="left"><strong><?php echo $row_qr_admin['id']; ?></strong></div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nome:</div></td>
      <td><div align="left">
        <input name="nome" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_admin['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Senha:</div></td>
      <td><div align="left">
        <input name="senha" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_admin['senha'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Level:</div></td>
      <td><label>
        <select name="situacao" class="imputTxt" id="situacao">
          <option value="admin" <?php if (!(strcmp("admin", $row_qr_admin['situacao']))) {echo "selected=\"selected\"";} ?>>Administrador</option>
          <option value="user" <?php if (!(strcmp("user", $row_qr_admin['situacao']))) {echo "selected=\"selected\"";} ?>>Operador</option>
                </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><div align="left">
        <input type="submit" id="form1" class="BnT" value="Atualizar" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_admin['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_admin);
?>
