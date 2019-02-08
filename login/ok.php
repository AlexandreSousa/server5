<?php require_once('Connections/Conexao.php'); ?>
<?php
$ip = getenv("REMOTE_ADDR");
 ?>
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

$teste = $_SESSION['mmusrname'] = $login;

$colname_qr_user = "-1";
if (isset($_GET['ip'])) {
  $colname_qr_user = $_GET['ip'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_user = sprintf("SELECT * FROM usuarios WHERE ip = '$ip'", GetSQLValueString($colname_qr_user, "text"));
$qr_user = mysql_query($query_qr_user, $Conexao) or die(mysql_error());
$row_qr_user = mysql_fetch_assoc($qr_user);
$totalRows_qr_user = mysql_num_rows($qr_user);
?>
<?php include "config.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style4 {
	font-size: 12px;
	font-weight: bold;
	color: #FF0000;
}
.style5 {
	color: #FF0000;
	font-weight: bold;
}
.style6 {color: #FFFFFF}
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="286" border="0" align="center">
  <tr>
    <td><span class="style5"><?php echo nl2br($row_qr_user['msg']); ?></span></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="350" border="0" align="center">
  <tr>
    <td width="238" background="imagens/bg_parceiros.gif"><span class="style6">Desenvolvido por Alexandre Sousa</span></td>
  </tr>
  <tr>
    <td height="130" align="center" bgcolor="#999900"><p>Você esta conectado<br />
      Aguarde o Redirecionamento em <?php echo "$redir"; ?> Segundos </p>
   <meta http-equiv='refresh' content='<?php echo "$redir"; ?>;URL=<?php echo "$siteprovedor"; ?>'>
      <p><a href="<?php echo "$siteprovedor"; ?>">Navegar na internet </a></p>
    <p></p></td>
  </tr>
  <tr>
    <td align="center" background="imagens/bg_parceiros.gif"><span class="style4">União Maker Desenvolvimentos</span></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_user);
?>
