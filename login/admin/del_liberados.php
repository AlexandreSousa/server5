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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM squi_liebados WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($deleteSQL, $Conexao) or die(mysql_error());
  echo "<p align='center'><strong>Deletado com Sucesso</strong></p>";
  include "liberados_sql.php";
  echo "<meta http-equiv='refresh' content='0;URL=?pg=add_liberados'>";
}

$colname_qr_liberados = "-1";
if (isset($_GET['id'])) {
  $colname_qr_liberados = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_liberados = sprintf("SELECT * FROM squi_liebados WHERE id = %s", GetSQLValueString($colname_qr_liberados, "int"));
$qr_liberados = mysql_query($query_qr_liberados, $Conexao) or die(mysql_error());
$row_qr_liberados = mysql_fetch_assoc($qr_liberados);
$totalRows_qr_liberados = mysql_num_rows($qr_liberados);
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
mysql_free_result($qr_liberados);
?>
