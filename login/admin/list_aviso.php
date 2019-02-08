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

$maxRows_qr_aviso = 10;
$pageNum_qr_aviso = 0;
if (isset($_GET['pageNum_qr_aviso'])) {
  $pageNum_qr_aviso = $_GET['pageNum_qr_aviso'];
}
$startRow_qr_aviso = $pageNum_qr_aviso * $maxRows_qr_aviso;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_aviso = "SELECT * FROM aviso";
$query_limit_qr_aviso = sprintf("%s LIMIT %d, %d", $query_qr_aviso, $startRow_qr_aviso, $maxRows_qr_aviso);
$qr_aviso = mysql_query($query_limit_qr_aviso, $Conexao) or die(mysql_error());
$row_qr_aviso = mysql_fetch_assoc($qr_aviso);

if (isset($_GET['totalRows_qr_aviso'])) {
  $totalRows_qr_aviso = $_GET['totalRows_qr_aviso'];
} else {
  $all_qr_aviso = mysql_query($query_qr_aviso);
  $totalRows_qr_aviso = mysql_num_rows($all_qr_aviso);
}
$totalPages_qr_aviso = ceil($totalRows_qr_aviso/$maxRows_qr_aviso)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab1" id="tabela_exemplo">
  <tr>
    <th>id</th>
    <th>aviso</th>
    <th>taget</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr class="tab1">
      <td><?php echo $row_qr_aviso['id']; ?></td>
      <td><?php echo $row_qr_aviso['aviso']; ?></td>
      <td><?php echo $row_qr_aviso['taget']; ?></td>
      <td><div align="center"><a href="?pg=edit_aviso&id=<?php echo $row_qr_aviso['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></div></td>
      <td><div align="center"><a href="?pg=del_aviso&id=<?php echo $row_qr_aviso['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></div></td>
    </tr>
    <?php } while ($row_qr_aviso = mysql_fetch_assoc($qr_aviso)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_aviso);
?>
