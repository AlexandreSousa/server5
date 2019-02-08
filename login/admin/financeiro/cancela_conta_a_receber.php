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

$maxRows_qr_list_conta = 30;
$pageNum_qr_list_conta = 0;
if (isset($_GET['pageNum_qr_list_conta'])) {
  $pageNum_qr_list_conta = $_GET['pageNum_qr_list_conta'];
}
$startRow_qr_list_conta = $pageNum_qr_list_conta * $maxRows_qr_list_conta;

$colname_qr_list_conta = "-1";
if (isset($_GET['status'])) {
  $colname_qr_list_conta = $_GET['status'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_list_conta = "SELECT * FROM f_contas_receber WHERE status = 'aberto'";
$query_limit_qr_list_conta = sprintf("%s LIMIT %d, %d", $query_qr_list_conta, $startRow_qr_list_conta, $maxRows_qr_list_conta);
$qr_list_conta = mysql_query($query_limit_qr_list_conta, $Conexao) or die(mysql_error());
$row_qr_list_conta = mysql_fetch_assoc($qr_list_conta);

if (isset($_GET['totalRows_qr_list_conta'])) {
  $totalRows_qr_list_conta = $_GET['totalRows_qr_list_conta'];
} else {
  $all_qr_list_conta = mysql_query($query_qr_list_conta);
  $totalRows_qr_list_conta = mysql_num_rows($all_qr_list_conta);
}
$totalPages_qr_list_conta = ceil($totalRows_qr_list_conta/$maxRows_qr_list_conta)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" class="tab1" id="tabela_exemplo">
  <tr>
    <th>id</th>
    <th>UserName</th>
    <th>cliente</th>
    <th>tipo_documento</th>
    <th>n_documento</th>
    <th>n_parcela</th>
    <th>valor</th>
    <th>obs</th>
    <th>emissao</th>
    <th>vencimento</th>
    <th>status</th>
    <th>Ação</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_list_conta['id']; ?></td>
      <td><?php echo $row_qr_list_conta['UserName']; ?></td>
      <td><?php echo $row_qr_list_conta['cliente']; ?></td>
      <td><?php echo $row_qr_list_conta['tipo_documento']; ?></td>
      <td><?php echo $row_qr_list_conta['n_documento']; ?></td>
      <td><?php echo $row_qr_list_conta['n_parcela']; ?></td>
      <td><?php echo $row_qr_list_conta['valor']; ?></td>
      <td><?php echo $row_qr_list_conta['obs']; ?></td>
      <td><?php echo $row_qr_list_conta['emissao']; ?></td>
      <td><?php echo $row_qr_list_conta['vencimento']; ?></td>
      <td><?php echo $row_qr_list_conta['status']; ?></td>
      <td><a href="?pg=financeiro/configm_cancela_conta_a_receber&id=<?php echo $row_qr_list_conta['id']; ?>"><img src="../imagens/apagar.gif" width="22" height="22" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_list_conta = mysql_fetch_assoc($qr_list_conta)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_list_conta);
?>