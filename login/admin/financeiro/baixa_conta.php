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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE f_contas_receber SET UserName=%s, cliente=%s, n_documento=%s, valor=%s, obs=%s, vencimento=%s, status=%s, data_recebido=%s WHERE id=%s",
                       GetSQLValueString($_POST['UserName'], "text"),
                       GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['n_documento'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['vencimento'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['data_recebido'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "CONTA BAIXADA COM SUCESSO";
  echo "<meta http-equiv='refresh' content='2;URL=?pg=financeiro/list_conta_a_receber'>";
}

$colname_qr_baixa = "-1";
if (isset($_GET['id'])) {
  $colname_qr_baixa = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_baixa = sprintf("SELECT * FROM f_contas_receber WHERE id = %s", GetSQLValueString($colname_qr_baixa, "int"));
$qr_baixa = mysql_query($query_qr_baixa, $Conexao) or die(mysql_error());
$row_qr_baixa = mysql_fetch_assoc($qr_baixa);
$totalRows_qr_baixa = mysql_num_rows($qr_baixa);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="38%" align="right" nowrap="nowrap"><div align="right">Id:</div></td>
      <td width="62%" class="imputTxt"><?php echo $row_qr_baixa['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">UserName:</div></td>
      <td><input type="hidden" name="UserName" value="<?php echo htmlentities($row_qr_baixa['UserName'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['UserName']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Cliente:</div></td>
      <td><input type="hidden" name="cliente" value="<?php echo htmlentities($row_qr_baixa['cliente'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['cliente']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">N_documento:</div></td>
      <td><input type="hidden" name="n_documento" value="<?php echo htmlentities($row_qr_baixa['n_documento'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['n_documento']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input type="hidden" name="valor" value="<?php echo htmlentities($row_qr_baixa['valor'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['valor']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Obs:</div></td>
      <td><input name="obs" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_baixa['obs'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Vencimento:</div></td>
      <td><input type="hidden" name="vencimento" value="<?php echo htmlentities($row_qr_baixa['vencimento'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['vencimento']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Status:</div></td>
      <td><input type="hidden" name="status" value="fechado" size="32" />
        <span class="imputTxt"><?php echo $row_qr_baixa['status']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data_recebido:</div></td>
      <td><input name="data_recebido" type="text" class="imputTxt" value="<?php echo ("$ano-$mes-$dia"); ; ?>" /><input type="button" class="calendario" onclick="displayCalendar(document.forms[0].data_recebido,'yyyy-mm-dd',this)"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Baixar Fatura" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_baixa['id']; ?>" />
</form>
</body>
</html>
<?php
mysql_free_result($qr_baixa);
?>
