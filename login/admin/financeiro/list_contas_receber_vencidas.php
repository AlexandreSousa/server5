<?php require_once('../Connections/Conexao.php'); ?>
<?php $data = "$ano-$mes-$dia"; 
$data;
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_qr_vencimento = 30;
$pageNum_qr_vencimento = 0;
if (isset($_GET['pageNum_qr_vencimento'])) {
  $pageNum_qr_vencimento = $_GET['pageNum_qr_vencimento'];
}
$startRow_qr_vencimento = $pageNum_qr_vencimento * $maxRows_qr_vencimento;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_vencimento = "SELECT * FROM f_contas_receber WHERE f_contas_receber.vencimento <= '$data' AND f_contas_receber.status = 'aberto'";
$query_limit_qr_vencimento = sprintf("%s LIMIT %d, %d", $query_qr_vencimento, $startRow_qr_vencimento, $maxRows_qr_vencimento);
$qr_vencimento = mysql_query($query_limit_qr_vencimento, $Conexao) or die(mysql_error());
$row_qr_vencimento = mysql_fetch_assoc($qr_vencimento);

if (isset($_GET['totalRows_qr_vencimento'])) {
  $totalRows_qr_vencimento = $_GET['totalRows_qr_vencimento'];
} else {
  $all_qr_vencimento = mysql_query($query_qr_vencimento);
  $totalRows_qr_vencimento = mysql_num_rows($all_qr_vencimento);
}
$totalPages_qr_vencimento = ceil($totalRows_qr_vencimento/$maxRows_qr_vencimento)-1;

$queryString_qr_vencimento = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_vencimento") == false && 
        stristr($param, "totalRows_qr_vencimento") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_vencimento = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_vencimento = sprintf("&totalRows_qr_vencimento=%d%s", $totalRows_qr_vencimento, $queryString_qr_vencimento);
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
    <th>UserName</th>
    <th>Cliente</th>
    <th>Tipo Documento</th>
    <th>Numero Documento</th>
    <th>Numero da Parcela</th>
    <th>valor</th>
    <th>emissao</th>
    <th>vencimento</th>
    <th>status</th>
    <th>Ação</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_vencimento['UserName']; ?></td>
      <td><?php echo $row_qr_vencimento['cliente']; ?></td>
      <td><?php echo $row_qr_vencimento['tipo_documento']; ?></td>
      <td><?php echo $row_qr_vencimento['n_documento']; ?></td>
      <td><?php echo $row_qr_vencimento['n_parcela']; ?></td>
      <td><?php echo $row_qr_vencimento['valor']; ?></td>
      <td><?php echo $row_qr_vencimento['emissao']; ?></td>
      <td><?php echo $row_qr_vencimento['vencimento']; ?></td>
      <td><?php echo $row_qr_vencimento['status']; ?></td>
      <td><a href="?pg=financeiro/baixa_conta&id=<?php echo $row_qr_vencimento['id']; ?>"><img src="../imagens/money_add.png" width="22" height="22" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_vencimento = mysql_fetch_assoc($qr_vencimento)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_vencimento > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_vencimento=%d%s", $currentPage, 0, $queryString_qr_vencimento); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_vencimento > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_vencimento=%d%s", $currentPage, max(0, $pageNum_qr_vencimento - 1), $queryString_qr_vencimento); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_vencimento < $totalPages_qr_vencimento) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_vencimento=%d%s", $currentPage, min($totalPages_qr_vencimento, $pageNum_qr_vencimento + 1), $queryString_qr_vencimento); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_vencimento < $totalPages_qr_vencimento) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_vencimento=%d%s", $currentPage, $totalPages_qr_vencimento, $queryString_qr_vencimento); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_vencimento);
?>
