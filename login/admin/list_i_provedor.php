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

$maxRows_qr_inventario = 30;
$pageNum_qr_inventario = 0;
if (isset($_GET['pageNum_qr_inventario'])) {
  $pageNum_qr_inventario = $_GET['pageNum_qr_inventario'];
}
$startRow_qr_inventario = $pageNum_qr_inventario * $maxRows_qr_inventario;

$colname_qr_inventario = "-1";
if (isset($_GET['destino'])) {
  $colname_qr_inventario = $_GET['destino'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_inventario = "SELECT * FROM inventario WHERE destino = 'provedor' ORDER BY id ASC";
$query_limit_qr_inventario = sprintf("%s LIMIT %d, %d", $query_qr_inventario, $startRow_qr_inventario, $maxRows_qr_inventario);
$qr_inventario = mysql_query($query_limit_qr_inventario, $Conexao) or die(mysql_error());
$row_qr_inventario = mysql_fetch_assoc($qr_inventario);

if (isset($_GET['totalRows_qr_inventario'])) {
  $totalRows_qr_inventario = $_GET['totalRows_qr_inventario'];
} else {
  $all_qr_inventario = mysql_query($query_qr_inventario);
  $totalRows_qr_inventario = mysql_num_rows($all_qr_inventario);
}
$totalPages_qr_inventario = ceil($totalRows_qr_inventario/$maxRows_qr_inventario)-1;

$queryString_qr_inventario = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_inventario") == false && 
        stristr($param, "totalRows_qr_inventario") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_inventario = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_inventario = sprintf("&totalRows_qr_inventario=%d%s", $totalRows_qr_inventario, $queryString_qr_inventario);
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
    <th>Id</th>
    <th>Equipamento</th>
    <th>Descricao</th>
    <th>Data</th>
    <th>Valor</th>
    <th>Usuario</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_inventario['id']; ?></td>
      <td><?php echo $row_qr_inventario['equipamento']; ?></td>
      <td><?php echo $row_qr_inventario['descricao']; ?></td>
      <td><?php echo $row_qr_inventario['data']; ?></td>
      <td><?php echo $row_qr_inventario['valor']; ?></td>
      <td><?php echo $row_qr_inventario['usuario']; ?></td>
      <td><a href="?pg=edit_i_provedor&id=<?php echo $row_qr_inventario['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td><a href="javascript:confirmaExclusao('?pg=del_i_provedor&id=<?php echo $row_qr_inventario['id']; ?>')"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_inventario = mysql_fetch_assoc($qr_inventario)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_inventario > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_inventario=%d%s", $currentPage, 0, $queryString_qr_inventario); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_inventario > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_inventario=%d%s", $currentPage, max(0, $pageNum_qr_inventario - 1), $queryString_qr_inventario); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_inventario < $totalPages_qr_inventario) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_inventario=%d%s", $currentPage, min($totalPages_qr_inventario, $pageNum_qr_inventario + 1), $queryString_qr_inventario); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_inventario < $totalPages_qr_inventario) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_inventario=%d%s", $currentPage, $totalPages_qr_inventario, $queryString_qr_inventario); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_inventario);
?>
