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
  $deleteSQL = sprintf("DELETE FROM v_lan WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($deleteSQL, $Conexao) or die(mysql_error());
    $v_nal1 = $row_del_vlan['id_eth'];
	$id_vlan = $row_del_vlan['id'];
	//Carregar arquivos para levantar as v-lan que esta na pasta firewall
	shell_exec("ifconfig $v_nal1:id_vlan down");
  include "../firewall/up_vlan.php";
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_rede'>";
}

$colname_del_vlan = "-1";
if (isset($_GET['id'])) {
  $colname_del_vlan = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_del_vlan = sprintf("SELECT * FROM v_lan WHERE id = %s", GetSQLValueString($colname_del_vlan, "int"));
$del_vlan = mysql_query($query_del_vlan, $Conexao) or die(mysql_error());
$row_del_vlan = mysql_fetch_assoc($del_vlan);
$totalRows_del_vlan = mysql_num_rows($del_vlan);
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
mysql_free_result($del_vlan);
?>
