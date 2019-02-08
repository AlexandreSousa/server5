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

$maxRows_qr_admin = 10;
$pageNum_qr_admin = 0;
if (isset($_GET['pageNum_qr_admin'])) {
  $pageNum_qr_admin = $_GET['pageNum_qr_admin'];
}
$startRow_qr_admin = $pageNum_qr_admin * $maxRows_qr_admin;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_admin = "SELECT * FROM login";
$query_limit_qr_admin = sprintf("%s LIMIT %d, %d", $query_qr_admin, $startRow_qr_admin, $maxRows_qr_admin);
$qr_admin = mysql_query($query_limit_qr_admin, $Conexao) or die(mysql_error());
$row_qr_admin = mysql_fetch_assoc($qr_admin);

if (isset($_GET['totalRows_qr_admin'])) {
  $totalRows_qr_admin = $_GET['totalRows_qr_admin'];
} else {
  $all_qr_admin = mysql_query($query_qr_admin);
  $totalRows_qr_admin = mysql_num_rows($all_qr_admin);
}
$totalPages_qr_admin = ceil($totalRows_qr_admin/$maxRows_qr_admin)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab1" id="tabela_exemplo">
  <tr class="topo">
    <th width="3%"><div align="center"><strong>ID</strong></div></th>
    <th width="50%"><div align="center"><strong>NOME</strong></div></th>
    <th width="37%"><div align="center"><strong>SENHA</strong></div></th>
    <th width="37%">Level</th>
    <th colspan="2"><div align="center"><strong>AÇÕES</strong></div></th>
  </tr>
  <?php do { ?>
    <tr class="tab1">
      <td><?php 
	  $id = $row_qr_admin['id']; 
	  echo $id;
	  ?></td>
      <td><?php echo $row_qr_admin['nome']; ?></td>
      <td><?php echo $row_qr_admin['senha']; ?></td>
      <td><?php echo $row_qr_admin['situacao']; ?></td>
      <td width="5%"><a href="?pg=edit_admin&id=<?php echo $row_qr_admin['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="5%"><img src="../imagens/botao_drop.png" width="16" height="16" /></td>
    </tr>
    <?php } while ($row_qr_admin = mysql_fetch_assoc($qr_admin)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_admin);
?>
