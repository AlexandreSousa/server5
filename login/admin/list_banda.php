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

$maxRows_Recordset1qr_list_banda = 10;
$pageNum_Recordset1qr_list_banda = 0;
if (isset($_GET['pageNum_Recordset1qr_list_banda'])) {
  $pageNum_Recordset1qr_list_banda = $_GET['pageNum_Recordset1qr_list_banda'];
}
$startRow_Recordset1qr_list_banda = $pageNum_Recordset1qr_list_banda * $maxRows_Recordset1qr_list_banda;

mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_list_banda = "SELECT * FROM banda ORDER BY banda_down DESC";
$query_limit_Recordset1qr_list_banda = sprintf("%s LIMIT %d, %d", $query_Recordset1qr_list_banda, $startRow_Recordset1qr_list_banda, $maxRows_Recordset1qr_list_banda);
$Recordset1qr_list_banda = mysql_query($query_limit_Recordset1qr_list_banda, $Conexao) or die(mysql_error());
$row_Recordset1qr_list_banda = mysql_fetch_assoc($Recordset1qr_list_banda);

if (isset($_GET['totalRows_Recordset1qr_list_banda'])) {
  $totalRows_Recordset1qr_list_banda = $_GET['totalRows_Recordset1qr_list_banda'];
} else {
  $all_Recordset1qr_list_banda = mysql_query($query_Recordset1qr_list_banda);
  $totalRows_Recordset1qr_list_banda = mysql_num_rows($all_Recordset1qr_list_banda);
}
$totalPages_Recordset1qr_list_banda = ceil($totalRows_Recordset1qr_list_banda/$maxRows_Recordset1qr_list_banda)-1;

$queryString_Recordset1qr_list_banda = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1qr_list_banda") == false && 
        stristr($param, "totalRows_Recordset1qr_list_banda") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1qr_list_banda = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1qr_list_banda = sprintf("&totalRows_Recordset1qr_list_banda=%d%s", $totalRows_Recordset1qr_list_banda, $queryString_Recordset1qr_list_banda);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	font-weight: bold;
}
.style2 {font-size: 12px}
-->
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <td colspan="7" bgcolor="#FF9900"><strong>Banda</strong></td>
  </tr>
  <tr>
    <th width="5%">ID</th>
    <th width="36%">Descrição</th>
    <th width="22%">Download</th>
    <th width="20%">Upload</th>
    <th width="8%">Cadastrar</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" bgcolor="#CCCCCC"><span class="style1"><?php $id = $row_Recordset1qr_list_banda['id']; 
	  echo $id;
	  ?></span></td>
      <td><span class="style2"><?php echo $row_Recordset1qr_list_banda['desc']; ?></span></td>
      <td><span class="style2"><?php echo $row_Recordset1qr_list_banda['banda_down']; ?></span></td>
      <td><span class="style2"><?php echo $row_Recordset1qr_list_banda['banda_up']; ?></span></td>
      <td align="center"><a href="?pg=add_banda"><img src="../imagens/filenew2.png" width="22" height="22" border="0" /></a></td>
      <td width="5%" align="center"><a href="?pg=edit_banda&id=<?php echo $row_Recordset1qr_list_banda['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="4%" align="center"><a href="?pg=del_banda&id=<?php echo $row_Recordset1qr_list_banda['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_Recordset1qr_list_banda = mysql_fetch_assoc($Recordset1qr_list_banda)); ?>
  <tr>
    <td colspan="7" align="center"><table border="0">
        <tr>
          <td><?php if ($pageNum_Recordset1qr_list_banda > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1qr_list_banda=%d%s", $currentPage, 0, $queryString_Recordset1qr_list_banda); ?>">First</a>
                <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_Recordset1qr_list_banda > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1qr_list_banda=%d%s", $currentPage, max(0, $pageNum_Recordset1qr_list_banda - 1), $queryString_Recordset1qr_list_banda); ?>">Previous</a>
                <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_Recordset1qr_list_banda < $totalPages_Recordset1qr_list_banda) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1qr_list_banda=%d%s", $currentPage, min($totalPages_Recordset1qr_list_banda, $pageNum_Recordset1qr_list_banda + 1), $queryString_Recordset1qr_list_banda); ?>">Next</a>
                <?php } // Show if not last page ?>          </td>
          <td><?php if ($pageNum_Recordset1qr_list_banda < $totalPages_Recordset1qr_list_banda) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1qr_list_banda=%d%s", $currentPage, $totalPages_Recordset1qr_list_banda, $queryString_Recordset1qr_list_banda); ?>">Last</a>
                <?php } // Show if not last page ?>          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1qr_list_banda);
?>
