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

$maxRows_qr_vencidas = 30;
$pageNum_qr_vencidas = 0;
if (isset($_GET['pageNum_qr_vencidas'])) {
  $pageNum_qr_vencidas = $_GET['pageNum_qr_vencidas'];
}
$startRow_qr_vencidas = $pageNum_qr_vencidas * $maxRows_qr_vencidas;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_vencidas = "SELECT * FROM f_contas_pagar WHERE f_contas_pagar.vencimento <= '$data' AND f_contas_pagar.status = 'aberto'";
$query_limit_qr_vencidas = sprintf("%s LIMIT %d, %d", $query_qr_vencidas, $startRow_qr_vencidas, $maxRows_qr_vencidas);
$qr_vencidas = mysql_query($query_limit_qr_vencidas, $Conexao) or die(mysql_error());
$row_qr_vencidas = mysql_fetch_assoc($qr_vencidas);

if (isset($_GET['totalRows_qr_vencidas'])) {
  $totalRows_qr_vencidas = $_GET['totalRows_qr_vencidas'];
} else {
  $all_qr_vencidas = mysql_query($query_qr_vencidas);
  $totalRows_qr_vencidas = mysql_num_rows($all_qr_vencidas);
}
$totalPages_qr_vencidas = ceil($totalRows_qr_vencidas/$maxRows_qr_vencidas)-1;

$queryString_qr_vencidas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_vencidas") == false && 
        stristr($param, "totalRows_qr_vencidas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_vencidas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_vencidas = sprintf("&totalRows_qr_vencidas=%d%s", $totalRows_qr_vencidas, $queryString_qr_vencidas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="1" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <th>Tipo Documento</th>
    <th>N&ordm; Documento</th>
    <th>N&ordm; Parcela</th>
    <th>Valor</th>
    <th>obs</th>
    <th>Emissao</th>
    <th>Vencimento</th>
    <th>A&ccedil;&atilde;o</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_vencidas['tipo_documento']; ?></td>
      <td><?php echo $row_qr_vencidas['n_documento']; ?></td>
      <td><?php echo $row_qr_vencidas['n_parcela']; ?></td>
      <td><?php echo $row_qr_vencidas['valor']; ?></td>
      <td><?php echo $row_qr_vencidas['obs']; ?></td>
      <td><?php echo $row_qr_vencidas['emissao']; ?></td>
      <td><?php echo $row_qr_vencidas['vencimento']; ?></td>
      <td><a href="?pg=financeiro/baixa_conta_paga&id=<?php echo $row_qr_vencidas['id']; ?>"><img src="../../imagens/money_add.png" width="22" height="22" border="0" id="sprytrigger1" /> </a><a href="?pg=financeiro/cancela_conta_paga&id=<?php echo $row_qr_vencidas['id']; ?>"><img src="../../imagens/money_delete.png" width="22" height="22" border="0" id="sprytrigger2" /></a></td>
    </tr>
    <?php } while ($row_qr_vencidas = mysql_fetch_assoc($qr_vencidas)); ?>
</table>
<div class="imputTxt" id="sprytooltip2"><img src="../../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Cancelar Pagamento</div>
<div class="imputTxt" id="sprytooltip1"><img src="../../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Fatura Pagamento</div>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_vencidas > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_vencidas=%d%s", $currentPage, 0, $queryString_qr_vencidas); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_vencidas > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_vencidas=%d%s", $currentPage, max(0, $pageNum_qr_vencidas - 1), $queryString_qr_vencidas); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_vencidas < $totalPages_qr_vencidas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_vencidas=%d%s", $currentPage, min($totalPages_qr_vencidas, $pageNum_qr_vencidas + 1), $queryString_qr_vencidas); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_vencidas < $totalPages_qr_vencidas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_vencidas=%d%s", $currentPage, $totalPages_qr_vencidas, $queryString_qr_vencidas); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_vencidas);
?>
