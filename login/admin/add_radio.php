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
  $insertSQL = sprintf("INSERT INTO radios (nome, modelo, ip, repetidora, mac, `mode`, operacao, imagem) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['repetidora'], "text"),
                       GetSQLValueString($_POST['mac'], "text"),
                       GetSQLValueString($_POST['mode'], "text"),
                       GetSQLValueString($_POST['operacao'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_radio'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_radio = "SELECT * FROM radios";
$qr_radio = mysql_query($query_qr_radio, $Conexao) or die(mysql_error());
$row_qr_radio = mysql_fetch_assoc($qr_radio);
$totalRows_qr_radio = mysql_num_rows($qr_radio);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_marcas = "SELECT * FROM marcas";
$qr_marcas = mysql_query($query_qr_marcas, $Conexao) or die(mysql_error());
$row_qr_marcas = mysql_fetch_assoc($qr_marcas);
$totalRows_qr_marcas = mysql_num_rows($qr_marcas);
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
      <td width="38%" align="right" nowrap="nowrap"><div align="right">Nome:</div></td>
      <td width="62%"><input name="nome" type="text" class="imputTxt" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Modelo:</div></td>
      <td><select name="modelo" class="imputTxt">
        <?php 
do {  
?>
        <option value="<?php echo $row_qr_marcas['marca']?>" ><?php echo $row_qr_marcas['marca']?></option>
        <?php
} while ($row_qr_marcas = mysql_fetch_assoc($qr_marcas));
?>
      </select>      </td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Ip:</div></td>
      <td><input name="ip" type="text" class="imputTxt" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Repetidora:</div></td>
      <td><label>
        <select name="repetidora" class="imputTxt" id="repetidora">
          <option value="...">Selecione</option>
          <option value="PTP">PTP</option>
          <option value="None">None</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Mac:</div></td>
      <td><input name="mac" type="text" class="imputTxt" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Mode:</div></td>
      <td><label>
        <select name="mode" class="imputTxt" id="mode">
         <option value="Selecione">Selecione</option>
         <option value="AP" >AP</option>
         <option value="Cliente" >Cliente</option>
         <option value="WDS" >WDS</option>
         <option value="AP+WDS" >AP+WDS</option>
        </select>
        <input type="hidden" name="imagem" value="img" size="32" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Operacao:</div></td>
      <td><label>
        <select name="operacao" class="imputTxt" id="operacao">
        <option value="Selecione">Selecione</option>
        <option value="Gateway" >Gateway</option>
        <option value="Bridge" >Bridge</option>
        <option value="Cliente ISP" >Cliente ISP</option>
        <option value="Roteador Wan Ethernet" >Roteador Wan Ethernet</option>
        <option value="Roteador Wan Wireless" >Roteador Wan Wireless</option>
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($qr_radio);

mysql_free_result($qr_marcas);
?>
