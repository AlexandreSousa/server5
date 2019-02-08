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
  $insertSQL = sprintf("INSERT INTO f_contas_receber (UserName, cliente, tipo_documento, n_documento, n_parcela, valor, obs, emissao, vencimento, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['UserName'], "text"),
                       GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['tipo_documento'], "text"),
                       GetSQLValueString($_POST['n_documento'], "text"),
                       GetSQLValueString($_POST['n_parcela'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['emissao'], "date"),
                       GetSQLValueString($_POST['vencimento'], "date"),
                       GetSQLValueString($_POST['status'], "text"));
                       

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_conta = "SELECT * FROM f_contas_receber";
$qr_conta = mysql_query($query_qr_conta, $Conexao) or die(mysql_error());
$row_qr_conta = mysql_fetch_assoc($qr_conta);
$totalRows_qr_conta = mysql_num_rows($qr_conta);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_usuarios = "SELECT * FROM usuarios";
$qr_usuarios = mysql_query($query_qr_usuarios, $Conexao) or die(mysql_error());
$row_qr_usuarios = mysql_fetch_assoc($qr_usuarios);
$totalRows_qr_usuarios = mysql_num_rows($qr_usuarios);

$colname_qr_cliente = "-1";
if (isset($_GET['id'])) {
  $colname_qr_cliente = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = sprintf("SELECT * FROM cliente WHERE id = %s", GetSQLValueString($colname_qr_cliente, "int"));
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);

$colname_u_select = "-1";
if (isset($_GET['id'])) {
  $colname_u_select = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_u_select = sprintf("SELECT * FROM usuarios WHERE id_cliente = %s", GetSQLValueString($colname_u_select, "text"));
$u_select = mysql_query($query_u_select, $Conexao) or die(mysql_error());
$row_u_select = mysql_fetch_assoc($u_select);
$totalRows_u_select = mysql_num_rows($u_select);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_tipo = "SELECT * FROM tipo_documento";
$qr_tipo = mysql_query($query_qr_tipo, $Conexao) or die(mysql_error());
$row_qr_tipo = mysql_fetch_assoc($qr_tipo);
$totalRows_qr_tipo = mysql_num_rows($qr_tipo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
      <td background="../../imagens/capa_fundo.png"><span class="style1">CADASTRO DE CONTAS A RECEBER</span></td>
    </tr>
  </table>
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="33%" align="right" nowrap="nowrap"><div align="right">UserName:</div></td>
      <td width="24%"><select name="UserName" class="imputTxt" id="UserName">
        <option value="Selecione" <?php if (!(strcmp("Selecione", $row_u_select['login']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
        <?php
do {  
?>
        <option value="<?php echo $row_qr_usuarios['login']?>"<?php if (!(strcmp($row_qr_usuarios['login'], $row_u_select['login']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_usuarios['login']?></option>
        <?php
} while ($row_qr_usuarios = mysql_fetch_assoc($qr_usuarios));
  $rows = mysql_num_rows($qr_usuarios);
  if($rows > 0) {
      mysql_data_seek($qr_usuarios, 0);
	  $row_qr_usuarios = mysql_fetch_assoc($qr_usuarios);
  }
?>
      </select></td>
      <td colspan="2" rowspan="4"><input type="hidden" name="status" value="aberto" size="32" />        <label></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Cliente:</div></td>
      <td><input name="cliente" type="text" class="imputTxt" value="<?php echo $row_qr_cliente['nome']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Tipo de Documento:</div></td>
      <td><select name="tipo_documento" class="imputTxt" id="n_documento">
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
        </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nª Documento:</div></td>
      <td><label>
        <input name="n_documento" type="text" class="imputTxt" value="<?php echo $documento; ?>" size="32" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><span id="sprytextfield1">
        <input name="valor" type="text" class="imputTxt" id="valor" onkeypress="FormataValor(this.id, 10, event)" size="10" />
      <span class="textfieldRequiredMsg">Valor Obrigatório.</span></span></td>
      <td width="21%"><div align="right"> Parcela:</div></td>
      <td width="22%"><label>
        <select name="n_parcela" class="imputTxt" id="n_parcela">
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
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Obs:</div></td>
      <td><input name="obs" type="text" class="imputTxt" value="........." size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data de Emissao:</div></td>
      <td colspan="3"><input  name="emissao" type="text" class="imputTxt" value="<?php echo ("$ano-$mes-$dia"); ?>">
      <input type="button" class="calendario" onclick="displayCalendar(document.forms[0].emissao,'yyyy-mm-dd',this)">
      Data no formato americanao ano-mes-dia</td>
     
     
      
      
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data de Vencimento:</div></td>
      <td colspan="3"><input name="vencimento" type="text" class="imputTxt" value="<?php echo ($vencimento); ?>" /><input type="button" class="calendario" onclick="displayCalendar(document.forms[0].vencimento,'yyyy-mm-dd',this)">
        Data No Formato Americano ano-mes-dia</td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Insert record" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="right" nowrap="nowrap">Porenquanto estou mantendo as datas no formato americano por motivo de compatibilidade espero na proxima atualização colocar as datas no formato Brasileiro</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_conta);

mysql_free_result($qr_usuarios);

mysql_free_result($qr_cliente);

mysql_free_result($u_select);

mysql_free_result($qr_tipo);
?>
