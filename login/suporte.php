<?php require_once('Connections/Conexao.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO suporte (chamado) VALUES (%s)",
                       GetSQLValueString($_POST['chamado'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

$maxRows_qr_chamado = 5;
$pageNum_qr_chamado = 0;
if (isset($_GET['pageNum_qr_chamado'])) {
  $pageNum_qr_chamado = $_GET['pageNum_qr_chamado'];
}
$startRow_qr_chamado = $pageNum_qr_chamado * $maxRows_qr_chamado;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_chamado = "SELECT * FROM suporte";
$query_limit_qr_chamado = sprintf("%s LIMIT %d, %d", $query_qr_chamado, $startRow_qr_chamado, $maxRows_qr_chamado);
$qr_chamado = mysql_query($query_limit_qr_chamado, $Conexao) or die(mysql_error());
$row_qr_chamado = mysql_fetch_assoc($qr_chamado);

if (isset($_GET['totalRows_qr_chamado'])) {
  $totalRows_qr_chamado = $_GET['totalRows_qr_chamado'];
} else {
  $all_qr_chamado = mysql_query($query_qr_chamado);
  $totalRows_qr_chamado = mysql_num_rows($all_qr_chamado);
}
$totalPages_qr_chamado = ceil($totalRows_qr_chamado/$maxRows_qr_chamado)-1;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_list = "SELECT * FROM suporte ORDER BY suporte.id ASC ";
$qr_list = mysql_query($query_qr_list, $Conexao) or die(mysql_error());
$row_qr_list = mysql_fetch_assoc($qr_list);
$totalRows_qr_list = mysql_num_rows($qr_list);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="200" border="1" align="center">
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_list['chamado']; ?></td>
    </tr>
    <?php } while ($row_qr_chamado = mysql_fetch_assoc($qr_chamado)); ?>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Chamado:</td>
      <td><input type="text" name="chamado" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_chamado);

mysql_free_result($qr_list);
?>
