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
  $insertSQL = sprintf("INSERT INTO palavresproibidas (palavra) VALUES (%s)",
                       GetSQLValueString($_POST['palavra'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  
  echo "<p align='center'><strong>Cadastrado com Sucesso</strong></p>";
  include "proibidos_sql.php";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_palavras = "SELECT * FROM palavresproibidas";
$qr_palavras = mysql_query($query_qr_palavras, $Conexao) or die(mysql_error());
$row_qr_palavras = mysql_fetch_assoc($qr_palavras);
$totalRows_qr_palavras = mysql_num_rows($qr_palavras);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {
	font-size: 12px;
	color: #FF0000;
}
.style3 {color: #FF0000}
-->
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" border="0" align="center">
    <tr>
      <td align="center" background="../imagens/message_toolbar_tile.gif"><span class="style2"><span class="style1">Cadastr de Sites Proibidos</span></span></td>
    </tr>
  </table>
  <table width="100%" align="center" id="tabela2">
    
    <tr valign="baseline">
      <td width="39%" align="right" nowrap="nowrap"><div align="right">Palavra:</div></td>
      <td width="61%"><input name="palavra" type="text" class="imputTxt" value="" size="20" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><div align="center">
        <input type="submit" class="BnT" id="form1" value="Gravar" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap"><p align="center" class="style2">Para bloquear acesso a um determinado site<br />
      insia apalavra do meio do site.</p>
      <p align="center" class="style2">EX.: www.google.com.br<br />
      Coloque apenas google</p>      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table width="100%" border="0" class="tab1" id="tabela_exemplo">
  <tr>
    <th colspan="5" background="../imagens/message_toolbar_tile.gif"><span class="style3">Lista de Palavras Boqueadas</span></th>
  </tr>
  <tr>
    <th width="3%">ID</th>
    <th width="30%">Palavra</th>
    <th width="49%">&nbsp;</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php 
	  $idi = $row_qr_palavras['id'];
	  echo $idi;
	   ?></td>
      <td><?php echo $row_qr_palavras['palavra']; ?></td>
      <td><img src="../imagens/editdelete.png" width="22" height="22" border="0" /></td>
      <td width="1%"><a href="?pg=edit_palavras&id=<?php echo $row_qr_palavras['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
      <td width="6%" align="center"><a href="?pg=dell_palavras&id=<?php echo $row_qr_palavras['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_palavras = mysql_fetch_assoc($qr_palavras)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($qr_palavras);
?>
