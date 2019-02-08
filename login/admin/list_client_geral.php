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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente_ls = "SELECT * FROM cliente";
$qr_cliente_ls = mysql_query($query_qr_cliente_ls, $Conexao) or die(mysql_error());
$row_qr_cliente_ls = mysql_fetch_assoc($qr_cliente_ls);
$totalRows_qr_cliente_ls = mysql_num_rows($qr_cliente_ls);

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
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <th colspan="8" bgcolor="#FF9900">Lista de Clientes</th>
  </tr>
  <tr>
    <th width="10%" background="../imagens/message_toolbar_tile.gif">ID</th>
    <th width="26%" background="../imagens/message_toolbar_tile.gif">Nome</th>
    <th width="16%" background="../imagens/message_toolbar_tile.gif">Endereço</th>
    <th width="13%" background="../imagens/message_toolbar_tile.gif">Cidade</th>
    <th width="12%" background="../imagens/message_toolbar_tile.gif">Telefone</th>
    <th width="13%" background="../imagens/message_toolbar_tile.gif">CPF/CNPJ</th>
    <th colspan="2" background="../imagens/message_toolbar_tile.gif">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><span class="style3"><?php echo $row_qr_cliente_ls['id']; ?></span></td>
      <td><span class="style3"><a href="?pg=edit_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><?php echo $row_qr_cliente_ls['nome']; ?></a></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['endereco']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['cidade']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['fonep']; ?></span></td>
      <td><span class="style3"><?php echo $row_qr_cliente_ls['cpfcnpj']; ?></span></td>
      <td width="5%" align="center"><a href="?pg=edit_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="5%" align="center"><a href="?pg=del_client&id=<?php echo $row_qr_cliente_ls['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_cliente_ls = mysql_fetch_assoc($qr_cliente_ls)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_cliente_ls);
?>
