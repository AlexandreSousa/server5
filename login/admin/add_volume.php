<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../class/funcoes.php'); ?>
<?php


$mdown = $_POST['down'];
$mup = $_POST['up'];


$mbitd = $mdown;
$download = $mbitd * 1024;
$download = $download * 1024;

$download;

$mbitu = $mup;
$upload = $mbitu * 1024;
$upload = $upload * 1024;
$upload;


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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO banwidth (down, up, tipo, mensal, randon) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString( $download, "text"),
                       GetSQLValueString( $upload, "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
					   GetSQLValueString($_POST['mensal'], "text"),
					   GetSQLValueString($_POST['randon'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

$maxRows_qr_volume = 30;
$pageNum_qr_volume = 0;
if (isset($_GET['pageNum_qr_volume'])) {
  $pageNum_qr_volume = $_GET['pageNum_qr_volume'];
}
$startRow_qr_volume = $pageNum_qr_volume * $maxRows_qr_volume;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_volume = "SELECT * FROM banwidth";
$query_limit_qr_volume = sprintf("%s LIMIT %d, %d", $query_qr_volume, $startRow_qr_volume, $maxRows_qr_volume);
$qr_volume = mysql_query($query_limit_qr_volume, $Conexao) or die(mysql_error());
$row_qr_volume = mysql_fetch_assoc($qr_volume);

if (isset($_GET['totalRows_qr_volume'])) {
  $totalRows_qr_volume = $_GET['totalRows_qr_volume'];
} else {
  $all_qr_volume = mysql_query($query_qr_volume);
  $totalRows_qr_volume = mysql_num_rows($all_qr_volume);
}
$totalPages_qr_volume = ceil($totalRows_qr_volume/$maxRows_qr_volume)-1;

$queryString_qr_volume = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_volume") == false && 
        stristr($param, "totalRows_qr_volume") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_volume = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_volume = sprintf("&totalRows_qr_volume=%d%s", $totalRows_qr_volume, $queryString_qr_volume);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {color: #FFFFFF}
.style3 {color: #FF0000}
-->
</style>

<script type="text/javascript">
$(function() {
  $("select[name=mensal]").change(function() {
  beforeSend:$("select[name=randon]").html('<option value="0">Aguarde carregando...</option>');
  
  var mensal = $("select[name=mensal]").val();
  $.post("randon_volume.php", {mensal: mensal},function(randon) {
  complete:$("select[name=randon]").html(randon);
  
    })
   
  })
   })
  </script>


</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap" background="../imagens/capa_fundo.png"><span class="style1">Adicionar Controle de Volume</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Tipo:</td>
      <td><input name="tipo" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td width="34%" align="right" nowrap="nowrap">Down:</td>
      <td width="66%"><input name="down" type="text" class="imputTxt" value="" size="10" />
       <img src="../imagens/infor32.gif" width="22" height="22" border="0" align="absmiddle" id="sprytrigger1" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Up:</td>
      <td><input name="up" type="text" class="imputTxt" value="" size="10" />
       <img src="../imagens/infor32.gif" width="22" height="22" border="0" align="absmiddle" id="sprytrigger2" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Internet Pre Paga:</td>
      
      <script type="text/javascript">
  $(document).ready(function(){
  $("#endereco").click(function(evento){
  		if ($("#endereco").attr("checked")){
			$(".alvo").css("display", "block");
		}else{
				$(".alvo").css("display", "none");
			}
		});
	});
	
</script>
      <td> <label><input type="checkbox" name="endereco" id="endereco" value="1" /></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div style="display: none; margin-top:12px" class="alvo">
  
  Mensal?
  
   </div></td>
      <td><div style="display: none; margin-top:12px" class="alvo">
  
  <select class="" id="fkCodEstado" name="mensal" onchange="simnao(this)">
              <?php simnao(); ?>
              </select>
  
  </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div style="display: none; margin-top:12px" class="alvo">
  
  Endereço
  
  </div></td>
      <td><div style="display: none; margin-top:12px" class="alvo">
  
  <select class="" id="randon" name="randon" >
                <option value="0">.....</option>
              </select>
  
  </div></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<div class="imputTxt" id="sprytooltip4"><img src="../imagens/infor32.gif" width="22" height="22" border="0" align="absmiddle" /> Selecione para Vender Internet Pre Paga</div>
<div class="imputTxt" id="sprytooltip3"><img src="../imagens/infor32.gif" width="22" height="22" border="0" align="absmiddle" /> Selecione <span class="style3">Não</span> para vender internet pre paga</div>
<div class="imputTxt" id="sprytooltip2"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Tarifação Feita Por Mega</div>
<div class="imputTxt" id="sprytooltip1"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Tarifação Feita Por Mega</div>
<table width="100%" border="0" align="center">
  <tr>
    <th width="25%" bgcolor="#666666" class="linha_tabela style2">Plano</th>
    <th width="30%" bgcolor="#666666" class="linha_tabela style2">Download</th>
    <th width="30%" bgcolor="#666666" class="linha_tabela style2">Upload</th>
    <th width="30%" bgcolor="#666666" class="linha_tabela style2">Mensal</th>
    <th width="30%" bgcolor="#666666" class="linha_tabela style2">Codigo</th>
    <th width="30%" bgcolor="#666666" class="linha_tabela style2">Usado</th>
    <th colspan="2" bgcolor="#666666" class="linha_tabela style2">Ações</th>
  </tr>
  <?php do { ?>
  <tr>
    <td class="linha_tabela"><?php echo $row_qr_volume['tipo']; ?></td>
    <td align="center" class="linha_tabela"><?php $vdown = $row_qr_volume['down']; 
	echo colores ($vdown, 3);
	?></td>
    <td align="center" class="linha_tabela"><?php $vup = $row_qr_volume['up'];
	echo colores ($vup, 3);
	 ?></td>
    <td align="center" class="linha_tabela"><?php echo $row_qr_volume['mensal']; ?></td>
    <td align="center" class="linha_tabela"><?php echo colores ($row_qr_volume['randon'], 2); ?></td>
    <td align="center" class="linha_tabela">&nbsp;</td>
    <td width="8%" align="center" class="linha_tabela"><a href="?pg=edit_volume&id=<?php echo $row_qr_volume['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
    <td width="7%" align="center" class="linha_tabela"><a href="javascript:confirmaExclusao('?pg=dell_volume&id=<?php echo $row_qr_volume['id']; ?>')"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
  </tr>
  <?php } while ($row_qr_volume = mysql_fetch_assoc($qr_volume)); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_volume > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_volume=%d%s", $currentPage, 0, $queryString_qr_volume); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_volume > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_volume=%d%s", $currentPage, max(0, $pageNum_qr_volume - 1), $queryString_qr_volume); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_volume < $totalPages_qr_volume) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_volume=%d%s", $currentPage, min($totalPages_qr_volume, $pageNum_qr_volume + 1), $queryString_qr_volume); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_volume < $totalPages_qr_volume) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_volume=%d%s", $currentPage, $totalPages_qr_volume, $queryString_qr_volume); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#fkCodEstado");
var sprytooltip4 = new Spry.Widget.Tooltip("sprytooltip4", "#endereco");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_volume);
?>
