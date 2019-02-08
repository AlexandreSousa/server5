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
  $updateSQL = sprintf("UPDATE aviso SET aviso=%s, taget=%s WHERE id=%s",
                       GetSQLValueString($_POST['aviso'], "text"),
                       GetSQLValueString($_POST['taget'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_aviso'>";
}

$colname_qr_aviso = "-1";
if (isset($_GET['id'])) {
  $colname_qr_aviso = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_aviso = sprintf("SELECT * FROM aviso WHERE id = %s", GetSQLValueString($colname_qr_aviso, "int"));
$qr_aviso = mysql_query($query_qr_aviso, $Conexao) or die(mysql_error());
$row_qr_aviso = mysql_fetch_assoc($qr_aviso);
$totalRows_qr_aviso = mysql_num_rows($qr_aviso);

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
  <table align="center" id="tabela_exemplo">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id:</td>
      <td><?php echo $row_qr_aviso['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Aviso:</td>
      <td><textarea name="aviso" cols="45" rows="5" class="imputTxt" id="aviso"><?php echo htmlentities($row_qr_aviso['aviso'], ENT_COMPAT, 'utf-8'); ?></textarea>
      <label></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Taget:</td>
      <td><div align="left">
        <label>
        <select name="taget" id="taget">
          <option value="geral">Geral</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qr_login['ip']?>"><?php echo $row_qr_login['login']?></option>
          <?php
} while ($row_qr_login = mysql_fetch_assoc($qr_login));
  $rows = mysql_num_rows($qr_login);
  if($rows > 0) {
      mysql_data_seek($qr_login, 0);
	  $row_qr_login = mysql_fetch_assoc($qr_login);
  }
?>
        </select>
        </label>
</div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_aviso['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_aviso);

mysql_free_result($qr_login);
?>
