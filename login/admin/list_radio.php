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

$maxRows_qr_radio = 30;
$pageNum_qr_radio = 0;
if (isset($_GET['pageNum_qr_radio'])) {
  $pageNum_qr_radio = $_GET['pageNum_qr_radio'];
}
$startRow_qr_radio = $pageNum_qr_radio * $maxRows_qr_radio;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_radio = "SELECT * FROM radios";
$query_limit_qr_radio = sprintf("%s LIMIT %d, %d", $query_qr_radio, $startRow_qr_radio, $maxRows_qr_radio);
$qr_radio = mysql_query($query_limit_qr_radio, $Conexao) or die(mysql_error());
$row_qr_radio = mysql_fetch_assoc($qr_radio);

if (isset($_GET['totalRows_qr_radio'])) {
  $totalRows_qr_radio = $_GET['totalRows_qr_radio'];
} else {
  $all_qr_radio = mysql_query($query_qr_radio);
  $totalRows_qr_radio = mysql_num_rows($all_qr_radio);
}
$totalPages_qr_radio = ceil($totalRows_qr_radio/$maxRows_qr_radio)-1;

$queryString_qr_radio = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_radio") == false && 
        stristr($param, "totalRows_qr_radio") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_radio = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_radio = sprintf("&totalRows_qr_radio=%d%s", $totalRows_qr_radio, $queryString_qr_radio);
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
    <th width="112">Nome</th>
    <th width="124">Modelo</th>
    <th width="90">IP</th>
    <th width="141">Repetidora</th>
    <th width="104">MAC</th>
    <th width="113">Mode</th>
    <th width="216">Operacao</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_radio['nome']; ?></td>
      <td><?php echo $row_qr_radio['modelo']; ?></td>
      <td><?php echo $row_qr_radio['ip']; ?></td>
      <td><?php echo $row_qr_radio['repetidora']; ?></td>
      <td><?php echo $row_qr_radio['mac']; ?></td>
      <td><?php echo $row_qr_radio['mode']; ?></td>
      <td><?php echo $row_qr_radio['operacao']; ?></td>
      <td width="26"><a href="?pg=edit_radio&id=<?php echo $row_qr_radio['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="30"><a href="javascript:confirmaExclusao('del_radio&id=<?php echo $row_qr_radio['id']; ?>')"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_radio = mysql_fetch_assoc($qr_radio)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_radio > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_radio=%d%s", $currentPage, 0, $queryString_qr_radio); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_radio > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_radio=%d%s", $currentPage, max(0, $pageNum_qr_radio - 1), $queryString_qr_radio); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_radio < $totalPages_qr_radio) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_radio=%d%s", $currentPage, min($totalPages_qr_radio, $pageNum_qr_radio + 1), $queryString_qr_radio); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_radio < $totalPages_qr_radio) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_radio=%d%s", $currentPage, $totalPages_qr_radio, $queryString_qr_radio); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($qr_radio);
?>
