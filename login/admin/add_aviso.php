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
  $insertSQL = sprintf("INSERT INTO aviso (aviso, taget) VALUES (%s, %s)",
                       GetSQLValueString($_POST['aviso'], "text"),
                       GetSQLValueString($_POST['taget'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
   echo "<meta http-equiv='refresh' content='0;URL=?pg=list_aviso'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_aviso = "SELECT * FROM aviso";
$qr_aviso = mysql_query($query_qr_aviso, $Conexao) or die(mysql_error());
$row_qr_aviso = mysql_fetch_assoc($qr_aviso);
$totalRows_qr_aviso = mysql_num_rows($qr_aviso);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = "SELECT * FROM usuarios";
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);
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
      <td colspan="2" align="right" nowrap="nowrap">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Aviso:</td>
      <td><label>
        <textarea name="aviso" cols="45" rows="5" class="imputTxt" id="aviso"></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Taget:</td>
      <td><div align="left"><select name="taget" class="imputTxt" id="taget">
            <option value="geral">Geral</option>
            <?php
do {  
?>
            <option value="<?php echo $row_qr_cliente['ip']?>"><?php echo $row_qr_cliente['login']?></option>
            <?php
} while ($row_qr_cliente = mysql_fetch_assoc($qr_cliente));
  $rows = mysql_num_rows($qr_cliente);
  if($rows > 0) {
      mysql_data_seek($qr_cliente, 0);
	  $row_qr_cliente = mysql_fetch_assoc($qr_cliente);
  }
?>
          </select>
          </div>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_aviso);

mysql_free_result($qr_cliente);
?>
