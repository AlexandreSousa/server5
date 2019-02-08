<?php require_once('Connections/Conexao.php'); ?>
<?php
$user = $_SESSION['MM_Username'];	

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

$colname_qr_usuarios = "-1";
if (isset($_GET['login'])) {
  $colname_qr_usuarios = $_GET['login'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_usuarios = sprintf("SELECT * FROM usuarios WHERE login = '$user'", GetSQLValueString($colname_qr_usuarios, "text"));
$qr_usuarios = mysql_query($query_qr_usuarios, $Conexao) or die(mysql_error());
$row_qr_usuarios = mysql_fetch_assoc($qr_usuarios);
$totalRows_qr_usuarios = mysql_num_rows($qr_usuarios);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="?pg=painel_db">
<table width="100%" border="0" align="center">
  
  <tr>
    <td width="306" align="right">&nbsp;</td>
    <td width="617">&nbsp;</td>
    <td width="22">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Usuário:</div></td>
    <td class="tooltipContent"><?php $user = $_SESSION['MM_Username']; 
		echo $user; ?>	</td>
    <td class="tooltipContent">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Proxy:</div></td>
    <td class="tooltipContent"><div id="CollapsiblePanel2" class="CollapsiblePanel">
        <div tabindex="0"><a href="#"><?php echo $row_qr_usuarios['proxy']; ?></a></div>
        <div class="CollapsiblePanelContent">
          <label>
          <input name="proxy" type="text" id="proxy" size="15" />
          </label>
          <label>
          <input type="submit" name="button2" id="button2" value="Solicita" />
          </label>
        </div>
      </div></td>
    <td class="tooltipContent"><img src="imagens/mini_squid.jpg" name="sprytrigger3" width="22" height="22" id="sprytrigger3" /></td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Pagina Inicial:</div></td>
    <td class="tooltipContent"><div id="CollapsiblePanel1" class="CollapsiblePanel">
        <div tabindex="0"><a href="#"><?php echo $row_qr_usuarios['site']; ?></a></div>
        <div class="CollapsiblePanelContent">
          <label>
          <input name="site" type="text" id="site" value="" size="14" />
            </label>
          <label>
          <input type="submit" name="button" id="button" value="Modificar" />
        </label>
</div>
    </div></td>
    <td class="tooltipContent"><img src="imagens/application-x-smb-workgroup.png" width="22" height="22" border="0" id="sprytrigger1" /></td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Downloa:</div></td>
    <td class="tooltipContent"><?php $bunda = $row_qr_usuarios['banda']; 
	
	
	$colname_qr_banda = "-1";
if (isset($_GET['id'])) {
  $colname_qr_banda = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_banda = sprintf("SELECT * FROM banda WHERE id = '$bunda'", GetSQLValueString($colname_qr_banda, "int"));
$qr_banda = mysql_query($query_qr_banda, $Conexao) or die(mysql_error());
$row_qr_banda = mysql_fetch_assoc($qr_banda);
$totalRows_qr_banda = mysql_num_rows($qr_banda);
	?>
      <div id="CollapsiblePanel3">
        <div tabindex="0"><?php echo $row_qr_banda['banda_down']; ?></div>
        <div class="CollapsiblePanelContent">
          <label>
          <input name="banda" type="text" id="banda" size="15" />
          </label>
          <label>
          <input type="submit" name="Solicita" id="Solicita" value="Solicita" />
          </label>
        </div>
      </div></td>
    <td class="tooltipContent"><img src="imagens/funcionarios.jpg" width="22" height="22" border="0" id="sprytrigger2" /></td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Upload:</div></td>
    <td class="tooltipContent"><?php echo $row_qr_banda['banda_up']; ?></td>
    <td class="tooltipContent">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Agendamento:</div></td>
    <td class="tooltipContent">&nbsp;</td>
    <td class="tooltipContent">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="tooltipContent"><div align="right">Volume:</div></td>
    <td class="tooltipContent">&nbsp;</td>
    <td class="tooltipContent">&nbsp;</td>
  </tr>
</table>
</form>
<div class="imputTxt" id="sprytooltip3"><img src="imagens/mini_squid.jpg" width="22" height="22" border="0" align="absmiddle" />Solicitar Mudanças no Proxy como Ativação e Desativação</div>
<div class="imputTxt" id="sprytooltip2"><img src="imagens/atraso.png" alt="" width="22" height="22" border="0" align="absmiddle" /> Solicitar Upgrade de Banda</div>
<div class="imputTxt" id="sprytooltip1"><img src="imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Mudar Pagina Inicial coloque ela no formato http://www.sitedesejado.com.br</div>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#sprytrigger3");
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {contentIsOpen:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_usuarios);

mysql_free_result($qr_banda);
?>
