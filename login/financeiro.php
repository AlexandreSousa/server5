<?php require_once('Connections/Conexao.php'); ?>
<?php
	$user = $_SESSION['MM_Username'];
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

$maxRows_qr_financeiro = 10;
$pageNum_qr_financeiro = 0;
if (isset($_GET['pageNum_qr_financeiro'])) {
  $pageNum_qr_financeiro = $_GET['pageNum_qr_financeiro'];
}
$startRow_qr_financeiro = $pageNum_qr_financeiro * $maxRows_qr_financeiro;

$colname_qr_financeiro = "-1";
if (isset($_GET['UserName'])) {
  $colname_qr_financeiro = $_GET['UserName'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_financeiro = sprintf("SELECT * FROM f_contas_receber WHERE UserName = '$user' AND  status = 'aberto'", GetSQLValueString($colname_qr_financeiro, "text"));
$query_limit_qr_financeiro = sprintf("%s LIMIT %d, %d", $query_qr_financeiro, $startRow_qr_financeiro, $maxRows_qr_financeiro);
$qr_financeiro = mysql_query($query_limit_qr_financeiro, $Conexao) or die(mysql_error());
$row_qr_financeiro = mysql_fetch_assoc($qr_financeiro);

if (isset($_GET['totalRows_qr_financeiro'])) {
  $totalRows_qr_financeiro = $_GET['totalRows_qr_financeiro'];
} else {
  $all_qr_financeiro = mysql_query($query_qr_financeiro);
  $totalRows_qr_financeiro = mysql_num_rows($all_qr_financeiro);
}
$totalPages_qr_financeiro = ceil($totalRows_qr_financeiro/$maxRows_qr_financeiro)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td><strong>Parcelas em Aberto</strong></td>
  </tr>
  <tr id="tabela_exemplo" class="tab1">
    <td align="center"><table width="100%" border="0">
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Documento</th>
          <th>Valor</th>
          <th>Emissão</th>
          <th>Vencimento</th>
          <th>Status</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_qr_financeiro['id']; ?></td>
            <td><?php echo $row_qr_financeiro['tipo_documento']; ?></td>
            <td><?php echo $row_qr_financeiro['n_documento']; ?></td>
            <td><?php echo $row_qr_financeiro['valor']; ?></td>
            <td><?php echo $row_qr_financeiro['emissao']; ?></td>
            <td><?php echo $row_qr_financeiro['vencimento']; ?></td>
            <td><?php echo $row_qr_financeiro['status']; ?></td>
          </tr>
          <?php } while ($row_qr_financeiro = mysql_fetch_assoc($qr_financeiro)); ?>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_financeiro);
?>
