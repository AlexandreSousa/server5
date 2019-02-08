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
  $insertSQL = sprintf("INSERT INTO inventario (equipamento, descricao, `data`, valor, usuario, destino) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['equipamento'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
					   GetSQLValueString($_POST['destino'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
    echo "<meta http-equiv='refresh' content='0;URL=?pg=list_inventario'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_inventario = "SELECT * FROM inventario";
$qr_inventario = mysql_query($query_qr_inventario, $Conexao) or die(mysql_error());
$row_qr_inventario = mysql_fetch_assoc($qr_inventario);
$totalRows_qr_inventario = mysql_num_rows($qr_inventario);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_login = "SELECT * FROM usuarios";
$qr_login = mysql_query($query_qr_login, $Conexao) or die(mysql_error());
$row_qr_login = mysql_fetch_assoc($qr_login);
$totalRows_qr_login = mysql_num_rows($qr_login);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="37%" align="right" nowrap="nowrap"><div align="right">Equipamento:</div></td>
      <td width="63%"><input name="equipamento" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><div align="right">Descricao:</div></td>
      <td><label>
        <textarea name="descricao" cols="29" rows="3" class="imputTxt" id="descricao"></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Data:</div></td>
      <td><input name="data" type="text" class="imputTxt" value="<?php echo ("$semana, $dia de $mes de $ano"); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input name="valor" type="text" class="imputTxt" onKeyPress="FormataValor(this.id, 10, event)" id="valor" size="10"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Usuario:</div></td>
      <td><label>
        <select name="usuario" class="imputTxt" id="usuario">
          <?php
do {  
?>
          <option value="<?php echo $row_qr_login['login']?>"><?php echo $row_qr_login['login']?></option>
          <?php
} while ($row_qr_login = mysql_fetch_assoc($qr_login));
  $rows = mysql_num_rows($qr_login);
  if($rows > 0) {
      mysql_data_seek($qr_login, 0);
	  $row_qr_login = mysql_fetch_assoc($qr_login);
  }
?>
        </select>
        <input name="destino" type="hidden" id="destino" value="cliente" />
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_inventario);

mysql_free_result($qr_login);
?>
