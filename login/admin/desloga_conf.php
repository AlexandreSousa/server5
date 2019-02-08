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
  $updateSQL = sprintf("UPDATE deslogar_metodo SET metodo=%s, pings=%s WHERE id=%s",
                       GetSQLValueString($_POST['metodo'], "text"),
					   GetSQLValueString($_POST['pings'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
}

$colname_qr_deslogar = "-1";
if (isset($_GET['id'])) {
  $colname_qr_deslogar = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_deslogar = sprintf("SELECT * FROM deslogar_metodo WHERE id = '1'", GetSQLValueString($colname_qr_deslogar, "int"));
$qr_deslogar = mysql_query($query_qr_deslogar, $Conexao) or die(mysql_error());
$row_qr_deslogar = mysql_fetch_assoc($qr_deslogar);
$totalRows_qr_deslogar = mysql_num_rows($qr_deslogar);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {color: #FF0000}
.style3 {color: #006633}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" border="0" align="center">
    <tr>
      <td background="../imagens/capa_fundo.png"><span class="style1">METODO PARA DESLOGAR OS CLIENTES</span></td>
    </tr>
  </table>
  <table width="100%" align="center">
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="imputTxt">Metodo Atualmente Ativo:</td>
      <td class="imputTxt">
	  <?php $comando = $row_qr_deslogar['metodo']; 
	  
	  
	  if($comando == ""){
	  
	  echo "<script>alert('Precisa declarar um metodo')</script>";
	  }
	  else{
	     echo $row_qr_deslogar['metodo'];
	  }
	  
	  
	  ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td width="34%" align="right" nowrap="nowrap" class="imputTxt">Escolha o Metodo:</td>
      <td width="66%" class="imputTxt"><label><?php 
		$tipo = $row_qr_deslogar['metodo'];
		
             if (arping == $tipo){
	   
	   echo  "<input type='radio' class='imputTxt' name='metodo' id='metodo' value='ping' /> ping";
       }
	   else
	   {
	  echo  "<input type='radio' class='imputTxt' name='metodo' id='metodo' value='arping' /> arping";
	   }
	    ?>
	  </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="imputTxt">Quantidade de Ping Antes de Desloga:</td>
      <td><label>
        <input name="pings" type="text" class="imputTxt" id="pings" value="<?php echo $row_qr_deslogar['pings']; ?>" size="2" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Gravar" />
      <label></label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_qr_deslogar['id']; ?>" />
</form>
<div class="imputTxt" id="sprytooltip2"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Numeros de envio de <span class="style2">pings</span> para <span class="style3">deslogar</span> o cliente</div>
<div class="imputTxt" id="sprytooltip1"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> O metodo <span class="style2">ARPING</span> e o mais recomendado use o metodo <span class="style2">PING</span> somente se tiver problemas com o <span class="style2">ARPING</span> </div>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#metodo");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#pings");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_deslogar);
?>
