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
  $updateSQL = sprintf("UPDATE parametros SET site=%s, fone=%s, `time`=%s, ip1=%s, ip2=%s, ip3=%s, ip4=%s, p_proxy=%s WHERE id=%s",
                       GetSQLValueString($_POST['site'], "text"),
                       GetSQLValueString($_POST['fone'], "text"),
                       GetSQLValueString($_POST['time'], "text"),
                       GetSQLValueString($_POST['ip1'], "text"),
					   GetSQLValueString($_POST['ip2'], "text"),
					   GetSQLValueString($_POST['ip3'], "text"),
					   GetSQLValueString($_POST['ip4'], "text"),
                       GetSQLValueString($_POST['p_proxy'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "DADOS AUTERADOS CON SUCESSO";
}

mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1parametos = "SELECT * FROM parametros";
$Recordset1parametos = mysql_query($query_Recordset1parametos, $Conexao) or die(mysql_error());
$row_Recordset1parametos = mysql_fetch_assoc($Recordset1parametos);
$totalRows_Recordset1parametos = mysql_num_rows($Recordset1parametos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Configuração de Parametros</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="29%" align="right" nowrap="nowrap">Id:</td>
      <td width="71%"><?php echo $row_Recordset1parametos['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site:</td>
      <td><input type="text" name="site" value="<?php echo htmlentities($row_Recordset1parametos['site'], ENT_COMPAT, 'utf-8'); ?>" size="32" /> 
        Site que o cliente sera redirecionado apos o login</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fone:</td>
      <td><input type="text" name="fone" value="<?php echo htmlentities($row_Recordset1parametos['fone'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        Telefone do Provedor</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Time:</td>
      <td><input type="text" name="time" value="<?php echo htmlentities($row_Recordset1parametos['time'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        Tempo que o cliente devera espera ate ser redirecionado </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IP Servidor:</td>
      <td><label>
        <input name="ip1" type="text" id="ip1" value="<?php echo $row_Recordset1parametos['ip1']; ?>" size="2" maxlength="3" />
        <input name="ip2" type="text" id="ip2" value="<?php echo $row_Recordset1parametos['ip2']; ?>" size="2" maxlength="3" />
        <input name="ip3" type="text" id="ip3" value="<?php echo $row_Recordset1parametos['ip3']; ?>" size="2" maxlength="3" />
        <input name="ip4" type="text" id="ip4" value="<?php echo $row_Recordset1parametos['ip4']; ?>" size="2" maxlength="3" />
      </label>        
      Ip do servidor de autenticação</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Porta do Proxy:</td>
      <td><input type="text" name="p_proxy" value="<?php echo htmlentities($row_Recordset1parametos['p_proxy'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        Porta a qual o squid ira escutar</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar dados" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1parametos['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1parametos);
?>
