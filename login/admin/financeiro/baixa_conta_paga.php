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
  $updateSQL = sprintf("UPDATE f_contas_pagar SET tipo_documento=%s, n_documento=%s, n_parcela=%s, valor=%s, obs=%s, emissao=%s, vencimento=%s, status=%s, data_recebido=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo_documento'], "text"),
                       GetSQLValueString($_POST['n_documento'], "text"),
                       GetSQLValueString($_POST['n_parcela'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['emissao'], "date"),
                       GetSQLValueString($_POST['vencimento'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['data_recebido'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
    echo "CONTA BAIXADA COM SUCESSO";
  echo "<meta http-equiv='refresh' content='2;URL=?pg=financeiro/list_conta_pagar'>";
}

$colname_qr_paga = "-1";
if (isset($_GET['id'])) {
  $colname_qr_paga = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_paga = sprintf("SELECT * FROM f_contas_pagar WHERE id = %s", GetSQLValueString($colname_qr_paga, "int"));
$qr_paga = mysql_query($query_qr_paga, $Conexao) or die(mysql_error());
$row_qr_paga = mysql_fetch_assoc($qr_paga);
$totalRows_qr_paga = mysql_num_rows($qr_paga);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" border="0" align="center">
    <tr>
      <td background="../../imagens/capa_fundo.png"><span class="style1">BAIXAR CONTA A PAGAR</span></td>
    </tr>
  </table>
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="35%" align="right" nowrap="nowrap"><div align="right">Id:</div></td>
      <td width="65%" class="imputTxt"><?php echo $row_qr_paga['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Tipo Documento:</div></td>
      <td class="imputTxt"><input type="hidden" name="tipo_documento" value="<?php echo htmlentities($row_qr_paga['tipo_documento'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['tipo_documento']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nº Documento:</div></td>
      <td class="imputTxt"><input type="hidden" name="n_documento" value="<?php echo htmlentities($row_qr_paga['n_documento'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['n_documento']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nº Parcela:</div></td>
      <td class="imputTxt"><input type="hidden" name="n_parcela" value="<?php echo htmlentities($row_qr_paga['n_parcela'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['n_parcela']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td class="imputTxt"><input type="hidden" name="valor" value="<?php echo htmlentities($row_qr_paga['valor'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['valor']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Obs:</div></td>
      <td class="imputTxt"><input type="hidden" name="obs" value="<?php echo htmlentities($row_qr_paga['obs'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['obs']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Emissao:</div></td>
      <td class="imputTxt"><input type="hidden" name="emissao" value="<?php echo htmlentities($row_qr_paga['emissao'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['emissao']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Vencimento:</div></td>
      <td class="imputTxt"><input type="hidden" name="vencimento" value="<?php echo htmlentities($row_qr_paga['vencimento'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <?php echo $row_qr_paga['vencimento']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Status:</div></td>
      <td class="imputTxt"><input type="hidden" name="status" value="fechado" size="32" />
      <?php echo $row_qr_paga['status']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data_recebido:</div></td>
      <td><input name="data_recebido" type="text" class="imputTxt" value="<?php echo ("$ano-$mes-$dia"); ?>" size="10" />
      <input type="button" class="calendario" onclick="displayCalendar(document.forms[0].data_recebido,'yyyy-mm-dd',this)" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right"></div></td>
      <td><input type="submit" class="BnT" value="Baixar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_paga['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_paga);
?>
