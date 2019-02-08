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

$maxRows_qr_os_abetas = 30;
$pageNum_qr_os_abetas = 0;
if (isset($_GET['pageNum_qr_os_abetas'])) {
  $pageNum_qr_os_abetas = $_GET['pageNum_qr_os_abetas'];
}
$startRow_qr_os_abetas = $pageNum_qr_os_abetas * $maxRows_qr_os_abetas;


$user = $_SESSION['MM_Username'];

$colname_qr_os_abetas = "-1";
if (isset($_GET['estatus'])) {
  $colname_qr_os_abetas = $_GET['estatus'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_os_abetas = sprintf("SELECT * FROM os_servico WHERE estatus = 'aberto' AND solicitado = 'Alexandre'", GetSQLValueString($colname_qr_os_abetas, "text"));
$query_limit_qr_os_abetas = sprintf("%s LIMIT %d, %d", $query_qr_os_abetas, $startRow_qr_os_abetas, $maxRows_qr_os_abetas);
$qr_os_abetas = mysql_query($query_limit_qr_os_abetas, $Conexao) or die(mysql_error());
$row_qr_os_abetas = mysql_fetch_assoc($qr_os_abetas);

if (isset($_GET['totalRows_qr_os_abetas'])) {
  $totalRows_qr_os_abetas = $_GET['totalRows_qr_os_abetas'];
} else {
  $all_qr_os_abetas = mysql_query($query_qr_os_abetas);
  $totalRows_qr_os_abetas = mysql_num_rows($all_qr_os_abetas);
}
$totalPages_qr_os_abetas = ceil($totalRows_qr_os_abetas/$maxRows_qr_os_abetas)-1;

$queryString_qr_os_abetas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_os_abetas") == false && 
        stristr($param, "totalRows_qr_os_abetas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_os_abetas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_os_abetas = sprintf("&totalRows_qr_os_abetas=%d%s", $totalRows_qr_os_abetas, $queryString_qr_os_abetas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="1" class="tab1" id="tabela_exemplo">
  <tr>
    <th>Solicitante</th>
    <th>Solicitado</th>
    <th>Problema</th>
    <th>Data Abertura</th>
    <th>Hora Aberta</th>
    <th>estatus</th>
    <th colspan="3">A&ccedil;&otilde;es</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_os_abetas['solicitante']; ?></td>
      <td><?php echo $row_qr_os_abetas['solicitado']; ?></td>
      <td><?php echo $row_qr_os_abetas['problema']; ?></td>
      <td><?php echo $row_qr_os_abetas['data_abertura']; ?></td>
      <td><?php echo $row_qr_os_abetas['hora_aberta']; ?></td>
      <td><?php echo $row_qr_os_abetas['estatus']; ?></td>
      <td><img src="../imagens/kterm.png" width="22" height="22" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_qr_os_abetas = mysql_fetch_assoc($qr_os_abetas)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_os_abetas > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_os_abetas=%d%s", $currentPage, 0, $queryString_qr_os_abetas); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_os_abetas > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_os_abetas=%d%s", $currentPage, max(0, $pageNum_qr_os_abetas - 1), $queryString_qr_os_abetas); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_os_abetas < $totalPages_qr_os_abetas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_os_abetas=%d%s", $currentPage, min($totalPages_qr_os_abetas, $pageNum_qr_os_abetas + 1), $queryString_qr_os_abetas); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_os_abetas < $totalPages_qr_os_abetas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_os_abetas=%d%s", $currentPage, $totalPages_qr_os_abetas, $queryString_qr_os_abetas); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_os_abetas);
?>
