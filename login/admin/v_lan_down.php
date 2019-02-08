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

$colname_qr_vlan_dpow = "-1";
if (isset($_GET['id'])) {
  $colname_qr_vlan_dpow = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_vlan_dpow = sprintf("SELECT * FROM v_lan WHERE id = %s", GetSQLValueString($colname_qr_vlan_dpow, "int"));
$qr_vlan_dpow = mysql_query($query_qr_vlan_dpow, $Conexao) or die(mysql_error());
$row_qr_vlan_dpow = mysql_fetch_assoc($qr_vlan_dpow);
$totalRows_qr_vlan_dpow = mysql_num_rows($qr_vlan_dpow);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($qr_vlan_dpow);
?>
