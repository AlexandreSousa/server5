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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_qr_conta = 10;
$pageNum_qr_conta = 0;
if (isset($_GET['pageNum_qr_conta'])) {
  $pageNum_qr_conta = $_GET['pageNum_qr_conta'];
}
$startRow_qr_conta = $pageNum_qr_conta * $maxRows_qr_conta;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_conta = "SELECT * FROM f_contas_receber WHERE status = 'aberto'";
$query_limit_qr_conta = sprintf("%s LIMIT %d, %d", $query_qr_conta, $startRow_qr_conta, $maxRows_qr_conta);
$qr_conta = mysql_query($query_limit_qr_conta, $Conexao) or die(mysql_error());
$row_qr_conta = mysql_fetch_assoc($qr_conta);

if (isset($_GET['totalRows_qr_conta'])) {
  $totalRows_qr_conta = $_GET['totalRows_qr_conta'];
} else {
  $all_qr_conta = mysql_query($query_qr_conta);
  $totalRows_qr_conta = mysql_num_rows($all_qr_conta);
}
$totalPages_qr_conta = ceil($totalRows_qr_conta/$maxRows_qr_conta)-1;

$queryString_qr_conta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_conta") == false && 
        stristr($param, "totalRows_qr_conta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_conta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_conta = sprintf("&totalRows_qr_conta=%d%s", $totalRows_qr_conta, $queryString_qr_conta);
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
    <th>Cliente</th>
    <th>Tipo</th>
    <th>Documento</th>
    <th>Parcela</th>
    <th>Valor</th>
    <th>obs</th>
    <th>emissao</th>
    <th>vencimento</th>
    <th>status</th>
    <th>Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_conta['id']; ?></td>
      <td><?php echo $row_qr_conta['UserName']; ?></td>
      <td><?php echo $row_qr_conta['cliente']; ?></td>
      <td><?php echo $row_qr_conta['tipo_documento']; ?></td>
      <td><?php echo $row_qr_conta['n_documento']; ?></td>
      <td><?php echo $row_qr_conta['n_parcela']; ?></td>
      <td><?php echo $row_qr_conta['valor']; ?></td>
      <td><?php echo $row_qr_conta['obs']; ?></td>
      <td><?php echo $row_qr_conta['emissao']; ?></td>
      <td><?php echo $row_qr_conta['vencimento']; ?></td>
      <td><?php echo $row_qr_conta['status']; ?></td>
      <td><a href="?pg=financeiro/baixa_conta&id=<?php echo $row_qr_conta['id']; ?>"><img src="../imagens/money_add.png" width="22" height="22" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_conta = mysql_fetch_assoc($qr_conta)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_conta > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_conta=%d%s", $currentPage, 0, $queryString_qr_conta); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_conta > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_conta=%d%s", $currentPage, max(0, $pageNum_qr_conta - 1), $queryString_qr_conta); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_conta < $totalPages_qr_conta) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_conta=%d%s", $currentPage, min($totalPages_qr_conta, $pageNum_qr_conta + 1), $queryString_qr_conta); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_conta < $totalPages_qr_conta) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_conta=%d%s", $currentPage, $totalPages_qr_conta, $queryString_qr_conta); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_conta);
?>
