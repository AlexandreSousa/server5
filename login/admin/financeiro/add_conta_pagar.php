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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO f_contas_pagar (tipo_documento, n_documento, n_parcela, valor, obs, emissao, vencimento, status, data_recebido) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tipo_documento'], "text"),
                       GetSQLValueString($_POST['n_documento'], "text"),
                       GetSQLValueString($_POST['n_parcela'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['emissao'], "date"),
                       GetSQLValueString($_POST['vencimento'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['data_recebido'], "date"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_conta_paga = "SELECT * FROM f_contas_pagar";
$qr_conta_paga = mysql_query($query_qr_conta_paga, $Conexao) or die(mysql_error());
$row_qr_conta_paga = mysql_fetch_assoc($qr_conta_paga);
$totalRows_qr_conta_paga = mysql_num_rows($qr_conta_paga);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_plano = "SELECT * FROM f_planos";
$qr_plano = mysql_query($query_qr_plano, $Conexao) or die(mysql_error());
$row_qr_plano = mysql_fetch_assoc($qr_plano);
$totalRows_qr_plano = mysql_num_rows($qr_plano);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_tipo = "SELECT * FROM tipo_documento";
$qr_tipo = mysql_query($query_qr_tipo, $Conexao) or die(mysql_error());
$row_qr_tipo = mysql_fetch_assoc($qr_tipo);
$totalRows_qr_tipo = mysql_num_rows($qr_tipo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" border="0" align="center">
    <tr>
      <td background="../../imagens/capa_fundo.png"><span class="style1">CADASTRO DE CONTAS A PAGAR</span></td>
    </tr>
  </table>
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="34%" align="right" nowrap="nowrap"><div align="right">Tipo Documento:</div></td>
      <td colspan="3"><span id="spryselect1">
        <label>
        <select name="tipo_documento" class="imputTxt" id="tipo_documento">
          <option value="">Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qr_tipo['tipo']?>"><?php echo $row_qr_tipo['tipo']?></option>
          <?php
} while ($row_qr_tipo = mysql_fetch_assoc($qr_tipo));
  $rows = mysql_num_rows($qr_tipo);
  if($rows > 0) {
      mysql_data_seek($qr_tipo, 0);
	  $row_qr_tipo = mysql_fetch_assoc($qr_tipo);
  }
?>
        </select>
        </label>
      <span class="selectRequiredMsg">Tipo de Documento obrigatorio.</span></span>
        <input type="hidden" name="data_recebido" value="" size="32" />
        <input type="hidden" name="status" value="aberto" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nº Documento:</div></td>
      <td width="20%"><input name="n_documento" type="text" class="imputTxt" value="<?php echo $documento; ?>" size="10" /></td>
      <td width="10%" align="right">&nbsp;</td>
      <td width="36%">&nbsp;</td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><span id="sprytextfield1">
      <input name="valor" type="text" class="imputTxt" id="valor" onkeypress="FormataValor(this.id, 10, event)" size="10" />
      <span class="textfieldRequiredMsg">Valor Obrigatório.</span></span></td>
      <td align="right">Nº Parcela:</td>
      <td><select name="n_parcela" class="imputTxt" id="n_parcela">
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Obs:</div></td>
      <td><input name="obs" type="text" class="imputTxt" value="..." size="32" /></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Emissao:</div></td>
      <td colspan="3"><input  name="emissao" type="text" class="imputTxt" value="<?php echo ("$ano-$mes-$dia"); ?>" />
      <input type="button" class="calendario" onclick="displayCalendar(document.forms[0].emissao,'yyyy-mm-dd',this)" />
Data no formato americanao ano-mes-dia</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Vencimento:</div></td>
      <td colspan="3"><input name="vencimento" type="text" class="imputTxt" value="<?php echo ($vencimento); ?>" />
      <input type="button" class="calendario" onclick="displayCalendar(document.forms[0].vencimento,'yyyy-mm-dd',this)" />
      Data No Formato Americano ano-mes-dia</td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" value="Cadastrar" /></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_conta_paga);

mysql_free_result($qr_plano);

mysql_free_result($qr_tipo);
?>
