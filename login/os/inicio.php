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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_os = "SELECT * FROM os_servico";
$qr_os = mysql_query($query_qr_os, $Conexao) or die(mysql_error());
$row_qr_os = mysql_fetch_assoc($qr_os);
$totalRows_qr_os = mysql_num_rows($qr_os);

$vc = $_SESSION['MM_Username'];

$colname_qr_os_vc = "-1";
if (isset($_GET['solicitado'])) {
  $colname_qr_os_vc = $_GET['solicitado'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_os_vc = sprintf("SELECT * FROM os_servico WHERE solicitado = 'Alexandre'", GetSQLValueString($colname_qr_os_vc, "text"));
$qr_os_vc = mysql_query($query_qr_os_vc, $Conexao) or die(mysql_error());
$row_qr_os_vc = mysql_fetch_assoc($qr_os_vc);
$totalRows_qr_os_vc = mysql_num_rows($qr_os_vc);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="1" align="center">
  <tr>
    <td width="40%" align="right">&nbsp;</td>
    <td width="60%"><?php echo $_SESSION['MM_Username']; ?></td>
  </tr>
  <tr>
    <td align="right">Os Abertas:</td>
    <td><?php echo $totalRows_qr_os ?> </td>
  </tr>
  <tr>
    <td align="right">Os Abertas Para Voc&ecirc;:</td>
    <td><?php echo $totalRows_qr_os_vc ?> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_os);

mysql_free_result($qr_os_vc);
?>
