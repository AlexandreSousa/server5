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
  $insertSQL = sprintf("INSERT INTO login (nome, senha, situacao) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
					   GetSQLValueString($_POST['situacao'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
      echo "<meta http-equiv='refresh' content='0;URL=?pg=list_admin'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_admin = "SELECT * FROM login";
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
  <table width="102%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="32%" align="right" nowrap="nowrap"><div align="right">Nome:</div></td>
      <td width="68%"><input name="nome" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Senha:</div></td>
      <td><input name="senha" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Level:</div></td>
      <td><label>
        <select name="situacao" class="imputTxt" id="situacao">
          <option value="admin">Administrador</option>
          <option value="user">Operador</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" id="form1" class="BnT" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_admin);
?>
