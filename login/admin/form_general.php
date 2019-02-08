<?php require_once('../Connections/Conexao.php'); ?>
<?php $serial = $_POST['serial']; ?>
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
  $insertSQL = sprintf("INSERT INTO esec (login_u, hdalfa, serial, chave, randon, ip, mac) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['login_u'], "text"),
                       GetSQLValueString($_POST['hdalfa'], "text"),
                       GetSQLValueString($_POST['serial'], "text"),
                       GetSQLValueString($_POST['chave'], "text"),
                       GetSQLValueString($_POST['randon'], "text"),
					   GetSQLValueString($_POST['ip'], "text"),
					   GetSQLValueString($_POST['mac'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_auth = "SELECT * FROM esec";
$qr_auth = mysql_query($query_qr_auth, $Conexao) or die(mysql_error());
$row_qr_auth = mysql_fetch_assoc($qr_auth);
$totalRows_qr_auth = mysql_num_rows($qr_auth);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_user = "SELECT * FROM usuarios";
$qr_user = mysql_query($query_qr_user, $Conexao) or die(mysql_error());
$row_qr_user = mysql_fetch_assoc($qr_user);
$totalRows_qr_user = mysql_num_rows($qr_user);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de E-Sec Cliente</strong></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Login do Usuário:</td>
      <td><label>
        <select name="login_u" id="login_u">
          <?php
do {  
?>
          <option value="<?php echo $row_qr_user['id']?>"<?php if (!(strcmp($row_qr_user['id'], $row_qr_user['login']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_user['login']?></option>
          <?php
} while ($row_qr_user = mysql_fetch_assoc($qr_user));
  $rows = mysql_num_rows($qr_user);
  if($rows > 0) {
      mysql_data_seek($qr_user, 0);
	  $row_qr_user = mysql_fetch_assoc($qr_user);
  }
?>
                </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hdalfa:</td>
      <td><input type="text" name="hdalfa" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Serial:</td>
      <td><input type="text" name="serial" value="<?php echo $serial = $_POST[serial] ; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Chave:</td>
      <td><input type="text" name="chave" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Randon:</td>
      <td><input type="text" name="randon" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IP:</td>
      <td><label>
        <input type="text" name="ip" id="ip" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">MAC:</td>
      <td><label>
        <input type="text" name="mac" id="mac" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_auth);

mysql_free_result($qr_user);
?>
