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

$maxRows_qr_esec = 10;
$pageNum_qr_esec = 0;
if (isset($_GET['pageNum_qr_esec'])) {
  $pageNum_qr_esec = $_GET['pageNum_qr_esec'];
}
$startRow_qr_esec = $pageNum_qr_esec * $maxRows_qr_esec;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_esec = "SELECT * FROM esec";
$query_limit_qr_esec = sprintf("%s LIMIT %d, %d", $query_qr_esec, $startRow_qr_esec, $maxRows_qr_esec);
$qr_esec = mysql_query($query_limit_qr_esec, $Conexao) or die(mysql_error());
$row_qr_esec = mysql_fetch_assoc($qr_esec);

if (isset($_GET['totalRows_qr_esec'])) {
  $totalRows_qr_esec = $_GET['totalRows_qr_esec'];
} else {
  $all_qr_esec = mysql_query($query_qr_esec);
  $totalRows_qr_esec = mysql_num_rows($all_qr_esec);
}
$totalPages_qr_esec = ceil($totalRows_qr_esec/$maxRows_qr_esec)-1;

$queryString_qr_esec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_esec") == false && 
        stristr($param, "totalRows_qr_esec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_esec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_esec = sprintf("&totalRows_qr_esec=%d%s", $totalRows_qr_esec, $queryString_qr_esec);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="9" align="center" background="../imagens/message_toolbar_tile.gif" bgcolor="#FF0000"><span class="style1">Lista de Chaves dos Usuarios Discados</span></td>
  </tr>
  <tr align="center">
    <td width="3%" nowrap="nowrap">&nbsp;</td>
    <td width="2%" nowrap="nowrap"><strong>id</strong></td>
    <td width="20%" nowrap="nowrap"><strong> Alfa</strong></td>
    <td width="19%" nowrap="nowrap"><strong>Serial</strong></td>
    <td width="16%" nowrap="nowrap"><strong>Chave</strong></td>
    <td width="17%" nowrap="nowrap"><strong>Randon</strong></td>
    <td width="16%" nowrap="nowrap"><strong>Login</strong></td>
    <td colspan="2" nowrap="nowrap"><strong>Ações</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><img src="../imagens/cadeado.gif" width="22" height="22" /></td>
      <td align="center"><?php $idd = $row_qr_esec['id']; 
	echo $idd;?></td>
      <td align="center"><?php echo $row_qr_esec['hdalfa']; ?></td>
      <td align="center"><?php echo $row_qr_esec['serial']; ?></td>
      <td align="center"><img src="../img/key.png" width="16" height="16" border="0" align="absmiddle" /> <?php echo $row_qr_esec['chave']; ?></td>
      <td align="center"><?php echo $row_qr_esec['randon']; ?></td>
      <td align="center"><?php
	  $fff = $row_qr_esec['login_u'];
	  $colname_qr_user = "-1";
if (isset($_GET['id'])) {
  $colname_qr_user = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_user = sprintf("SELECT * FROM usuarios WHERE id = '$fff'", GetSQLValueString($colname_qr_user, "int"));
$qr_user = mysql_query($query_qr_user, $Conexao) or die(mysql_error());
$row_qr_user = mysql_fetch_assoc($qr_user);
$totalRows_qr_user = mysql_num_rows($qr_user);
	  
	  
	   echo $row_qr_user['login']; ?></td>
      <td width="3%" align="right"><img src="../imagens/botao_edit.png" width="16" height="16" /></td>
      <td width="4%" align="center"><img src="../imagens/botao_drop.png" width="16" height="16" /></td>
    </tr>
    <?php } while ($row_qr_esec = mysql_fetch_assoc($qr_esec)); ?>
  <tr>
    <td colspan="9" align="center"><table border="0">
        <tr>
          <td><?php if ($pageNum_qr_esec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_qr_esec=%d%s", $currentPage, 0, $queryString_qr_esec); ?>">First</a>
              <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_qr_esec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_qr_esec=%d%s", $currentPage, max(0, $pageNum_qr_esec - 1), $queryString_qr_esec); ?>">Previous</a>
              <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_qr_esec < $totalPages_qr_esec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_qr_esec=%d%s", $currentPage, min($totalPages_qr_esec, $pageNum_qr_esec + 1), $queryString_qr_esec); ?>">Next</a>
              <?php } // Show if not last page ?>          </td>
          <td><?php if ($pageNum_qr_esec < $totalPages_qr_esec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_qr_esec=%d%s", $currentPage, $totalPages_qr_esec, $queryString_qr_esec); ?>">Last</a>
              <?php } // Show if not last page ?>          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_esec);

mysql_free_result($qr_user);
?>
