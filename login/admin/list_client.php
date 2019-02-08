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

$maxRows_qr_cliente_ls = 10;
$pageNum_qr_cliente_ls = 0;
if (isset($_GET['pageNum_qr_cliente_ls'])) {
  $pageNum_qr_cliente_ls = $_GET['pageNum_qr_cliente_ls'];
}
$startRow_qr_cliente_ls = $pageNum_qr_cliente_ls * $maxRows_qr_cliente_ls;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente_ls = "SELECT * FROM cliente";
$query_limit_qr_cliente_ls = sprintf("%s LIMIT %d, %d", $query_qr_cliente_ls, $startRow_qr_cliente_ls, $maxRows_qr_cliente_ls);
$qr_cliente_ls = mysql_query($query_limit_qr_cliente_ls, $Conexao) or die(mysql_error());
$row_qr_cliente_ls = mysql_fetch_assoc($qr_cliente_ls);

if (isset($_GET['totalRows_qr_cliente_ls'])) {
  $totalRows_qr_cliente_ls = $_GET['totalRows_qr_cliente_ls'];
} else {
  $all_qr_cliente_ls = mysql_query($query_qr_cliente_ls);
  $totalRows_qr_cliente_ls = mysql_num_rows($all_qr_cliente_ls);
}
$totalPages_qr_cliente_ls = ceil($totalRows_qr_cliente_ls/$maxRows_qr_cliente_ls)-1;

$queryString_qr_cliente_ls = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_cliente_ls") == false && 
        stristr($param, "totalRows_qr_cliente_ls") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_cliente_ls = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_cliente_ls = sprintf("&totalRows_qr_cliente_ls=%d%s", $totalRows_qr_cliente_ls, $queryString_qr_cliente_ls);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style3 {font-size: 12px; font-weight: bold; }
-->
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <td colspan="8" bgcolor="#FF9900"><strong>Lista de Clientes</strong></td>
  </tr>
  <tr>
    <th width="3%">ID</th>
    <th width="33%">Nome</th>
    <th width="16%">Endereço</th>
    <th width="13%">Cidade</th>
    <th width="12%">Telefone</th>
    <th width="13%">CPF/CNPJ</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><span class="style3"><?php $id = $row_qr_cliente_ls['id']; 
	  echo $id;
	  ?></span></td>
      <td><div align="left"><span class="style3"><a href="?pg=edit_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><?php echo $row_qr_cliente_ls['nome']; ?></a></span></div></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['endereco']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['cidade']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['fonep']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['cpfcnpj']; ?></span></td>
      <td width="5%" align="center"><a href="?pg=edit_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="5%" align="center"><a href="?pg=del_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_cliente_ls = mysql_fetch_assoc($qr_cliente_ls)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_cliente_ls > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_qr_cliente_ls=%d%s", $currentPage, 0, $queryString_qr_cliente_ls); ?>">First</a>
        <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente_ls > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_qr_cliente_ls=%d%s", $currentPage, max(0, $pageNum_qr_cliente_ls - 1), $queryString_qr_cliente_ls); ?>">Previous</a>
        <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente_ls < $totalPages_qr_cliente_ls) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_qr_cliente_ls=%d%s", $currentPage, min($totalPages_qr_cliente_ls, $pageNum_qr_cliente_ls + 1), $queryString_qr_cliente_ls); ?>">Next</a>
        <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_cliente_ls < $totalPages_qr_cliente_ls) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_qr_cliente_ls=%d%s", $currentPage, $totalPages_qr_cliente_ls, $queryString_qr_cliente_ls); ?>">Last</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_cliente_ls);
?>
