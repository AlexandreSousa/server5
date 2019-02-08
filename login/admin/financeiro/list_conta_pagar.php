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

$maxRows_qr_conta_paga = 30;
$pageNum_qr_conta_paga = 0;
if (isset($_GET['pageNum_qr_conta_paga'])) {
  $pageNum_qr_conta_paga = $_GET['pageNum_qr_conta_paga'];
}
$startRow_qr_conta_paga = $pageNum_qr_conta_paga * $maxRows_qr_conta_paga;

$colname_qr_conta_paga = "-1";
if (isset($_GET['status'])) {
  $colname_qr_conta_paga = $_GET['status'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_conta_paga = "SELECT * FROM f_contas_pagar WHERE status = 'aberto'";
$query_limit_qr_conta_paga = sprintf("%s LIMIT %d, %d", $query_qr_conta_paga, $startRow_qr_conta_paga, $maxRows_qr_conta_paga);
$qr_conta_paga = mysql_query($query_limit_qr_conta_paga, $Conexao) or die(mysql_error());
$row_qr_conta_paga = mysql_fetch_assoc($qr_conta_paga);

if (isset($_GET['totalRows_qr_conta_paga'])) {
  $totalRows_qr_conta_paga = $_GET['totalRows_qr_conta_paga'];
} else {
  $all_qr_conta_paga = mysql_query($query_qr_conta_paga);
  $totalRows_qr_conta_paga = mysql_num_rows($all_qr_conta_paga);
}
$totalPages_qr_conta_paga = ceil($totalRows_qr_conta_paga/$maxRows_qr_conta_paga)-1;

$queryString_qr_conta_paga = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_conta_paga") == false && 
        stristr($param, "totalRows_qr_conta_paga") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_conta_paga = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_conta_paga = sprintf("&totalRows_qr_conta_paga=%d%s", $totalRows_qr_conta_paga, $queryString_qr_conta_paga);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td background="../../imagens/capa_fundo.png"><span class="style1">LISTA DE CONTAS A PAGAR ABERTAS</span></td>
  </tr>
</table>
<table width="100%" border="0" class="tab1" id="tabela_exemplo">
  <tr>
    <th>ID</th>
    <th>Tipo Documento</th>
    <th>Nº Documento</th>
    <th>Nº Parcelas</th>
    <th>Valor</th>
    <th>Obs</th>
    <th>Emissao</th>
    <th>Vencimento</th>
    <th>Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php $id = $row_qr_conta_paga['id']; 
	  echo $id;
	  ?></td>
      <td><?php echo $row_qr_conta_paga['tipo_documento']; ?></td>
      <td><?php $ndoc = $row_qr_conta_paga['n_documento']; 
	  echo $ndoc;
	  ?></td>
      <td><?php echo $row_qr_conta_paga['n_parcela']; ?></td>
      <td><?php echo $row_qr_conta_paga['valor']; ?></td>
      <td><?php echo $row_qr_conta_paga['obs']; ?></td>
      <td><?php echo $row_qr_conta_paga['emissao']; ?></td>
      <td><?php echo $row_qr_conta_paga['vencimento']; ?></td>
      <td><a href="?pg=financeiro/baixa_conta_paga&id=<?php echo $row_qr_conta_paga['id']; ?>"><img src="../../imagens/money_delete.png" width="22" height="22" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_conta_paga = mysql_fetch_assoc($qr_conta_paga)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_conta_paga > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_conta_paga=%d%s", $currentPage, 0, $queryString_qr_conta_paga); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_conta_paga > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_conta_paga=%d%s", $currentPage, max(0, $pageNum_qr_conta_paga - 1), $queryString_qr_conta_paga); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_conta_paga < $totalPages_qr_conta_paga) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_conta_paga=%d%s", $currentPage, min($totalPages_qr_conta_paga, $pageNum_qr_conta_paga + 1), $queryString_qr_conta_paga); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_conta_paga < $totalPages_qr_conta_paga) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_conta_paga=%d%s", $currentPage, $totalPages_qr_conta_paga, $queryString_qr_conta_paga); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($qr_conta_paga);
?>
