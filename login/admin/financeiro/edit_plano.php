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
  $updateSQL = sprintf("UPDATE f_planos SET plano=%s, descricao=%s, valor=%s, velocidade=%s, velocidade_nominal=%s, adesao=%s, multa=%s, website=%s WHERE id=%s",
                       GetSQLValueString($_POST['plano'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['velocidade'], "text"),
                       GetSQLValueString($_POST['velocidade_nominal'], "text"),
                       GetSQLValueString($_POST['adesao'], "text"),
                       GetSQLValueString($_POST['multa'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=?pg=financeiro/add_planos'>";
}

$colname_qr_up_plano = "-1";
if (isset($_GET['id'])) {
  $colname_qr_up_plano = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_up_plano = sprintf("SELECT * FROM f_planos WHERE id = %s", GetSQLValueString($colname_qr_up_plano, "int"));
$qr_up_plano = mysql_query($query_qr_up_plano, $Conexao) or die(mysql_error());
$row_qr_up_plano = mysql_fetch_assoc($qr_up_plano);
$totalRows_qr_up_plano = mysql_num_rows($qr_up_plano);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_banda = "SELECT * FROM banda";
$qr_banda = mysql_query($query_qr_banda, $Conexao) or die(mysql_error());
$row_qr_banda = mysql_fetch_assoc($qr_banda);
$totalRows_qr_banda = mysql_num_rows($qr_banda);
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
      <td nowrap="nowrap" align="right"><div align="right">Id:</div></td>
      <td class="imputTxt"><?php echo $row_qr_up_plano['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Plano:</div></td>
      <td><label>
        <select name="plano" class="imputTxt" id="plano">
          <?php
do {  
?>
          <option value="<?php echo $row_qr_banda['desc']?>"<?php if (!(strcmp($row_qr_banda['desc'], $row_qr_up_plano['plano']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_banda['desc']?></option>
          <?php
} while ($row_qr_banda = mysql_fetch_assoc($qr_banda));
  $rows = mysql_num_rows($qr_banda);
  if($rows > 0) {
      mysql_data_seek($qr_banda, 0);
	  $row_qr_banda = mysql_fetch_assoc($qr_banda);
  }
?>
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input name="valor" type="text" id="valor" onkeypress="FormataValor(this.id, 10, event)" size="10" maxlength="10" class="imputTxt" value="<?php echo htmlentities($row_qr_up_plano['valor'], ENT_COMPAT, 'utf-8'); ?>"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Velocidade:</div></td>
      <td><input name="velocidade" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_up_plano['velocidade'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Velocidade Nominal:</div></td>
      <td><input name="velocidade_nominal" type="text" class="imputTxt" value="<?php echo htmlentities($row_qr_up_plano['velocidade_nominal'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Adesao:</div></td>
      <td><input name="adesao" type="text" id="adesao" onkeypress="FormataValor(this.id, 10, event)" size="10" maxlength="10" class="imputTxt" value="<?php echo htmlentities($row_qr_up_plano['adesao'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Multa:</div></td>
      <td><input name="multa" type="text" id="multa" onkeypress="FormataValor(this.id, 10, event)" size="10" maxlength="10" class="imputTxt" value="<?php echo htmlentities($row_qr_up_plano['multa'], ENT_COMPAT, 'utf-8'); ?>"/></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><div align="right">Descricao:</div></td>
      <td><label>
        <textarea name="descricao" id="descricao" cols="45" rows="5"> <?php echo htmlentities($row_qr_up_plano['descricao'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Website:</div></td>
      <td><label>
        <select name="website" class="imputTxt" id="website">
          <option value="sim">Sim</option>
          <option value="nao">Não</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Atualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_up_plano['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_up_plano);

mysql_free_result($qr_banda);
?>
