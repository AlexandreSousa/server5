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
  $updateSQL = sprintf("UPDATE radios SET nome=%s, modelo=%s, ip=%s, repetidora=%s, mac=%s, `mode`=%s, operacao=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['modelo'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['repetidora'], "text"),
                       GetSQLValueString($_POST['mac'], "text"),
                       GetSQLValueString($_POST['mode'], "text"),
                       GetSQLValueString($_POST['operacao'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
   echo "<meta http-equiv='refresh' content='0;URL=?pg=list_radio'>";
}

$colname_Recordset1qr_radio = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1qr_radio = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_radio = sprintf("SELECT * FROM radios WHERE id = %s", GetSQLValueString($colname_Recordset1qr_radio, "int"));
$Recordset1qr_radio = mysql_query($query_Recordset1qr_radio, $Conexao) or die(mysql_error());
$row_Recordset1qr_radio = mysql_fetch_assoc($Recordset1qr_radio);
$totalRows_Recordset1qr_radio = mysql_num_rows($Recordset1qr_radio);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_modelo = "SELECT * FROM marcas";
$qr_modelo = mysql_query($query_qr_modelo, $Conexao) or die(mysql_error());
$row_qr_modelo = mysql_fetch_assoc($qr_modelo);
$totalRows_qr_modelo = mysql_num_rows($qr_modelo);
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
      <td width="36%" align="right" nowrap="nowrap"><div align="right">Id:</div></td>
      <td width="64%"><?php echo $row_Recordset1qr_radio['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Nome:</div></td>
      <td><input name="nome" type="text" class="imputTxt" value="<?php echo htmlentities($row_Recordset1qr_radio['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Modelo:</div></td>
      <td><select name="modelo" class="imputTxt">
        <?php 
do {  
?>
        <option value="<?php echo $row_qr_modelo['marca']?>" <?php if (!(strcmp($row_qr_modelo['marca'], htmlentities($row_Recordset1qr_radio['modelo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_qr_modelo['marca']?></option>
        <?php
} while ($row_qr_modelo = mysql_fetch_assoc($qr_modelo));
?>
      </select>
      </td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Ip:</div></td>
      <td><input name="ip" type="text" class="imputTxt" value="<?php echo htmlentities($row_Recordset1qr_radio['ip'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Repetidora:</div></td>
      <td><select name="repetidora" class="imputTxt">
     <option value="" ><?php echo $row_Recordset1qr_radio['repetidora']; ?></option>
             <option value="PTP">PTP</option>
          <option value="None">None</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Mac:</div></td>
      <td><input name="mac" type="text" class="imputTxt" value="<?php echo htmlentities($row_Recordset1qr_radio['mac'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Mode:</div></td>
      <td><select name="mode" class="imputTxt">
         <option value="Selecione" <?php if (!(strcmp("Selecione", $row_Recordset1qr_radio['mode']))) {echo "selected=\"selected\"";} ?>>Selecione</option>
         <option value="AP"  <?php if (!(strcmp("AP", $row_Recordset1qr_radio['mode']))) {echo "selected=\"selected\"";} ?>>AP</option>
         <option value="Cliente"  <?php if (!(strcmp("Cliente", $row_Recordset1qr_radio['mode']))) {echo "selected=\"selected\"";} ?>>Cliente</option>
         <option value="WDS"  <?php if (!(strcmp("WDS", $row_Recordset1qr_radio['mode']))) {echo "selected=\"selected\"";} ?>>WDS</option>
         <option value="AP+WDS"  <?php if (!(strcmp("AP+WDS", $row_Recordset1qr_radio['mode']))) {echo "selected=\"selected\"";} ?>>AP+WDS</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Operacao:</div></td>
      <td><select name="operacao" class="imputTxt">
        <option value="Gateway"  <?php if (!(strcmp("Gateway", $row_Recordset1qr_radio['operacao']))) {echo "selected=\"selected\"";} ?>>Gateway</option>
        <option value="Bridge"  <?php if (!(strcmp("Bridge", $row_Recordset1qr_radio['operacao']))) {echo "selected=\"selected\"";} ?>>Bridge</option>
        <option value="Cliente ISP"  <?php if (!(strcmp("Cliente ISP", $row_Recordset1qr_radio['operacao']))) {echo "selected=\"selected\"";} ?>>Cliente ISP</option>
        <option value="Roteador Wan Ethernet"  <?php if (!(strcmp("Roteador Wan Ethernet", $row_Recordset1qr_radio['operacao']))) {echo "selected=\"selected\"";} ?>>Roteador Wan Ethernet</option>
        <option value="Roteador Wan Wireless"  <?php if (!(strcmp("Roteador Wan Wireless", $row_Recordset1qr_radio['operacao']))) {echo "selected=\"selected\"";} ?>>Roteador Wan Wireless</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1qr_radio['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1qr_radio);

mysql_free_result($qr_modelo);
?>
