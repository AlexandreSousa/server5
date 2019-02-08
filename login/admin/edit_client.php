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
  $updateSQL = sprintf("UPDATE cliente SET nome=%s, endereco=%s, referencia=%s, cidade=%s, uf=%s, fonep=%s, datanas=%s, datacad=%s, email=%s, complemento=%s, bairro=%s, cep=%s, cpfcnpj=%s, ofone=%s, obs=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());

 echo "<meta http-equiv='refresh' content='0;URL=?pg=list_client'>";
}

$colname_qr_update_cliente = "-1";
if (isset($_GET['id'])) {
  $colname_qr_update_cliente = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_update_cliente = sprintf("SELECT * FROM cliente WHERE id = %s", GetSQLValueString($colname_qr_update_cliente, "int"));
$qr_update_cliente = mysql_query($query_qr_update_cliente, $Conexao) or die(mysql_error());
$row_qr_update_cliente = mysql_fetch_assoc($qr_update_cliente);
$totalRows_qr_update_cliente = mysql_num_rows($qr_update_cliente);

$cli = $row_qr_update_cliente['id'];

$colname_qr_login = "-1";
if (isset($_GET['id_cliente'])) {
  $colname_qr_login = $_GET['id_cliente'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_login = sprintf("SELECT * FROM usuarios WHERE id_cliente = '$cli'", GetSQLValueString($colname_qr_login, "text"));
$qr_login = mysql_query($query_qr_login, $Conexao) or die(mysql_error());
$row_qr_login = mysql_fetch_assoc($qr_login);
$totalRows_qr_login = mysql_num_rows($qr_login);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td width="62" align="right" nowrap="nowrap">Id:</td>
      <td width="237" align="left" nowrap="nowrap"><?php echo $row_qr_update_cliente['id']; ?></td>
      <td width="88" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="192">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="nome" value="<?php echo htmlentities($row_qr_update_cliente['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_qr_update_cliente['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Endereco:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="endereco" value="<?php echo htmlentities($row_qr_update_cliente['endereco'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">Complemento:</td>
      <td><input type="text" name="complemento" value="<?php echo htmlentities($row_qr_update_cliente['complemento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Referencia:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="referencia" value="<?php echo htmlentities($row_qr_update_cliente['referencia'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">Bairro:</td>
      <td><input type="text" name="bairro" value="<?php echo htmlentities($row_qr_update_cliente['bairro'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cidade:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="cidade" value="<?php echo htmlentities($row_qr_update_cliente['cidade'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">Cep:</td>
      <td><input type="text" name="cep" value="<?php echo htmlentities($row_qr_update_cliente['cep'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Uf:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="uf" value="<?php echo htmlentities($row_qr_update_cliente['uf'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">CPF/CNPJ:</td>
      <td><input type="text" name="cpfcnpj" value="<?php echo htmlentities($row_qr_update_cliente['cpfcnpj'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fone Principal:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="fonep" value="<?php echo htmlentities($row_qr_update_cliente['fonep'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">Celular:</td>
      <td><input type="text" name="ofone" value="<?php echo htmlentities($row_qr_update_cliente['ofone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data Nascimento:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="datanas" value="<?php echo htmlentities($row_qr_update_cliente['datanas'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td align="right" valign="top" nowrap="nowrap">Obs:</td>
      <td rowspan="2"><label>
        <textarea name="obs" id="obs" cols="30" rows="5"><?php echo htmlentities($row_qr_update_cliente['obs'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data Cadstro:</td>
      <td nowrap="nowrap" align="left"><input type="text" name="datacad" value="<?php echo htmlentities($row_qr_update_cliente['datacad'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td nowrap="nowrap" align="right"><input type="submit" value="Atalizar" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Logins Associados</strong></td>
    </tr>
    <?php do { ?>
      <tr valign="baseline">
        <td colspan="4" nowrap="nowrap">
        <?php
		$logins_a = $totalRows_qr_login; 
		if($logins_a == 0){
		echo 'NÃO POSSUI LOGIN ASOSSIADO';
		}else{
		?>
<table width="100%" border="0">
          <tr>
            <th align="center">&nbsp;</th>
            <th>Login</th>
            <th>Senha</th>
            <th>Situação</th>
            <th>Mac</th>
            <th colspan="2">Ações</th>
            </tr>
          <tr>
            <td width="7%" align="center"><img src="../imagens/agt_forum.png" width="22" height="22" border="0" align="absbottom" /></td>
            <td width="23%"><?php echo $row_qr_login['login']; ?></td>
            <td width="16%"><?php echo $row_qr_login['senha']; ?></td>
            <td width="20%" align="center"><?php echo $row_qr_login['situacao']; ?></td>
            <td width="34%"><?php echo $row_qr_login['mac']; ?></td>
            <td width="34%" align="center"><img src="../imagens/botao_edit.png" width="16" height="16" /></td>
            <td width="34%"><img src="../imagens/botao_drop.png" width="16" height="16" /></td>
          </tr>
        </table>
        <?php } ?>
        
        </td>
      </tr>
      <?php } while ($row_qr_login = mysql_fetch_assoc($qr_login)); ?>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_update_cliente['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_update_cliente);

mysql_free_result($qr_login);
?>
