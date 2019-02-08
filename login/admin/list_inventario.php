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

$maxRows_qr_cliente = 30;
$pageNum_qr_cliente = 0;
if (isset($_GET['pageNum_qr_cliente'])) {
  $pageNum_qr_cliente = $_GET['pageNum_qr_cliente'];
}
$startRow_qr_cliente = $pageNum_qr_cliente * $maxRows_qr_cliente;

$colname_qr_cliente = "-1";
if (isset($_GET['destino'])) {
  $colname_qr_cliente = $_GET['destino'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = "SELECT * FROM inventario WHERE destino = 'cliente' ORDER BY id ASC";
$query_limit_qr_cliente = sprintf("%s LIMIT %d, %d", $query_qr_cliente, $startRow_qr_cliente, $maxRows_qr_cliente);
$qr_cliente = mysql_query($query_limit_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);

if (isset($_GET['totalRows_qr_cliente'])) {
  $totalRows_qr_cliente = $_GET['totalRows_qr_cliente'];
} else {
  $all_qr_cliente = mysql_query($query_qr_cliente);
  $totalRows_qr_cliente = mysql_num_rows($all_qr_cliente);
}
$totalPages_qr_cliente = ceil($totalRows_qr_cliente/$maxRows_qr_cliente)-1;

$queryString_qr_cliente = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_cliente") == false && 
        stristr($param, "totalRows_qr_cliente") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_cliente = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_cliente = sprintf("&totalRows_qr_cliente=%d%s", $totalRows_qr_cliente, $queryString_qr_cliente);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" class="tab1" id="tabela_exemplo">
  <tr>
    <th>id</th>
    <th>Equipamento</th>
    <th>Descricao</th>
    <th>Data</th>
    <th>Valor</th>
    <th>Cliente Login</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_cliente['id']; ?></td>
      <td><?php echo $row_qr_cliente['equipamento']; ?></td>
      <td><?php echo $row_qr_cliente['descricao']; ?></td>
      <td><?php echo $row_qr_cliente['data']; ?></td>
      <td><?php echo $row_qr_cliente['valor']; ?></td>
      <td><?php echo $row_qr_cliente['usuario']; ?></td>
      <td><a href="?pg=edit_inventario&id=<?php echo $row_qr_cliente['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td><a href="javascript:confirmaExclusao('?pg=del_inventario&id=<?php echo $row_qr_cliente['id']; ?>')"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_cliente = mysql_fetch_assoc($qr_cliente)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_cliente > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_cliente=%d%s", $currentPage, 0, $queryString_qr_cliente); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_cliente=%d%s", $currentPage, max(0, $pageNum_qr_cliente - 1), $queryString_qr_cliente); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente < $totalPages_qr_cliente) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_cliente=%d%s", $currentPage, min($totalPages_qr_cliente, $pageNum_qr_cliente + 1), $queryString_qr_cliente); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente < $totalPages_qr_cliente) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_cliente=%d%s", $currentPage, $totalPages_qr_cliente, $queryString_qr_cliente); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($qr_cliente);
?>
