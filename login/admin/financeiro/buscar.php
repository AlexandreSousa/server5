<?php require_once('../Connections/Conexao.php'); ?>
<?php
$campo = $_POST['campo'];
$tabela = $_POST['tabela'];
$idf = "%$campo%";
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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = "SELECT *  FROM `cliente` WHERE `$tabela` LIKE CONVERT(_utf8 '$idf' USING latin1)";
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="1" class="tab1" id="tabela_exemplo">
  <tr>
    <th width="3%">ID</th>
    <th width="31%">Nome</th>
    <th width="19%">Fone</th>
    <th width="43%">CPF/CNPJ</th>
    <th width="4%">Ação</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php $idf = $row_qr_cliente['id'];
	echo $idf;
	 ?></td>
      <td><a href="?pg=financeiro/add_conta_receber&id=<?php echo $row_qr_cliente['id']; ?>"><?php echo $row_qr_cliente['nome']; ?></a></td>
      <td><?php echo $row_qr_cliente['ofone']; ?></td>
      <td><?php echo $row_qr_cliente['cpfcnpj']; ?></td>
      <td><a href="?pg=financeiro/add_conta_receber&id=<?php echo $row_qr_cliente['id']; ?>"><img src="../imagens/money_add.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_cliente = mysql_fetch_assoc($qr_cliente)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_cliente);
?>
