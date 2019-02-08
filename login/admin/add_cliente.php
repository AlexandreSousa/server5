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
  $insertSQL = sprintf("INSERT INTO cliente (nome, endereco, referencia, cidade, uf, fonep, datanas, datacad, email, complemento, bairro, cep, cpfcnpj, ofone, obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['uf'], "text"),
                       GetSQLValueString($_POST['fonep'], "text"),
                       GetSQLValueString($_POST['datanas'], "text"),
                       GetSQLValueString($_POST['datacad'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['cpfcnpj'], "text"),
                       GetSQLValueString($_POST['ofone'], "text"),
                       GetSQLValueString($_POST['obs'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
   echo "<meta http-equiv='refresh' content='0;URL=?pg=list_client'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_cliente = "SELECT * FROM cliente";
$qr_cliente = mysql_query($query_qr_cliente, $Conexao) or die(mysql_error());
$row_qr_cliente = mysql_fetch_assoc($qr_cliente);
$totalRows_qr_cliente = mysql_num_rows($qr_cliente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="604" align="center">
    <tr valign="baseline" class="celula">
      <td colspan="4" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de Cliente</strong></td>
    </tr>
    <tr valign="baseline" class="celula">
      <td align="right" nowrap="nowrap" class="celula">&nbsp;</td>
      <td align="left" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr valign="baseline" class="celula">
      <td width="108" align="right" nowrap="nowrap" class="celula"><div align="right">Nome:</div></td>
      <td width="192" align="left" nowrap="nowrap"><input name="nome" type="text" class="imputTxt" value="" size="32" /></td>
      <td width="223" align="right" nowrap="nowrap"><div align="right">Email:</div></td>
      <td width="286"><input name="email" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Endereço:</div></td>
      <td nowrap="nowrap" align="left"><input name="endereco" type="text" class="imputTxt" value="" size="32" /></td>
      <td nowrap="nowrap" align="right"><div align="right">Complemento:</div></td>
      <td><input name="complemento" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Referencia:</div></td>
      <td nowrap="nowrap" align="left"><input name="referencia" type="text" class="imputTxt" value="" size="32" /></td>
      <td nowrap="nowrap" align="right"><div align="right">Bairro:</div></td>
      <td><input name="bairro" type="text" class="imputTxt" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Cidade:</div></td>
      <td nowrap="nowrap" align="left"><input name="cidade" type="text" class="imputTxt" value="" size="20" /></td>
      <td nowrap="nowrap" align="right"><div align="right">Cep:</div></td>
      <td><input name="cep" type="text" class="imputTxt" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">UF:</div></td>
      <td nowrap="nowrap" align="left"><input name="uf" type="text" class="imputTxt" value="" size="4" /></td>
      <td nowrap="nowrap" align="right"><div align="right">CPF/CNPJ:</div></td>
      <td><input name="cpfcnpj" type="text" class="imputTxt" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Fone Principal:</div></td>
      <td nowrap="nowrap" align="left"><input name="fonep" type="text" class="imputTxt" value="" size="32" /></td>
      <td nowrap="nowrap" align="right"><div align="right">Celular</div></td>
      <td><input name="ofone" type="text" class="imputTxt" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data Nascimento:</div></td>
      <td nowrap="nowrap" align="left"><input name="datanas" type="text" class="imputTxt" value="" size="10" /></td>
      <td rowspan="2" align="right" valign="top" nowrap="nowrap"><div align="right">Obs:</div></td>
      <td rowspan="2"><label>
        <textarea name="obs" cols="30" rows="5" class="imputTxt" id="obs"></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="right">Data Cadastro:</div></td>
      <td nowrap="nowrap" align="left"><input name="datacad" type="text" class="imputTxt" value="" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form2" value="Gravar Dados" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_cliente);
?>
