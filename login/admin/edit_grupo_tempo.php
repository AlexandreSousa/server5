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
  $updateSQL = sprintf("UPDATE grupo_tempo SET `desc`=%s WHERE id=%s",
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
       echo "<meta http-equiv='refresh' content='0;URL=?pg=add_grupo_tempo'>";
}

$colname_qr_grupotempo = "-1";
if (isset($_GET['id'])) {
  $colname_qr_grupotempo = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_grupotempo = sprintf("SELECT * FROM grupo_tempo WHERE id = %s", GetSQLValueString($colname_qr_grupotempo, "int"));
$qr_grupotempo = mysql_query($query_qr_grupotempo, $Conexao) or die(mysql_error());
$row_qr_grupotempo = mysql_fetch_assoc($qr_grupotempo);
$totalRows_qr_grupotempo = mysql_num_rows($qr_grupotempo);
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
      <td width="40%" align="right" nowrap="nowrap">ID:</td>
      <td width="60%"><?php echo $row_qr_grupotempo['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descrição:</td>
      <td><input name="desc" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_grupotempo['desc'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_grupotempo['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_grupotempo);
?>
