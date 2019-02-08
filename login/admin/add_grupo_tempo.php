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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO grupo_tempo (`desc`) VALUES (%s)",
                       GetSQLValueString($_POST['desc'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

$maxRows_qr_tempo_grupo = 10;
$pageNum_qr_tempo_grupo = 0;
if (isset($_GET['pageNum_qr_tempo_grupo'])) {
  $pageNum_qr_tempo_grupo = $_GET['pageNum_qr_tempo_grupo'];
}
$startRow_qr_tempo_grupo = $pageNum_qr_tempo_grupo * $maxRows_qr_tempo_grupo;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_tempo_grupo = "SELECT * FROM grupo_tempo";
$query_limit_qr_tempo_grupo = sprintf("%s LIMIT %d, %d", $query_qr_tempo_grupo, $startRow_qr_tempo_grupo, $maxRows_qr_tempo_grupo);
$qr_tempo_grupo = mysql_query($query_limit_qr_tempo_grupo, $Conexao) or die(mysql_error());
$row_qr_tempo_grupo = mysql_fetch_assoc($qr_tempo_grupo);

if (isset($_GET['totalRows_qr_tempo_grupo'])) {
  $totalRows_qr_tempo_grupo = $_GET['totalRows_qr_tempo_grupo'];
} else {
  $all_qr_tempo_grupo = mysql_query($query_qr_tempo_grupo);
  $totalRows_qr_tempo_grupo = mysql_num_rows($all_qr_tempo_grupo);
}
$totalPages_qr_tempo_grupo = ceil($totalRows_qr_tempo_grupo/$maxRows_qr_tempo_grupo)-1;

$queryString_qr_tempo_grupo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_tempo_grupo") == false && 
        stristr($param, "totalRows_qr_tempo_grupo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_tempo_grupo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_tempo_grupo = sprintf("&totalRows_qr_tempo_grupo=%d%s", $totalRows_qr_tempo_grupo, $queryString_qr_tempo_grupo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap" bgcolor="#999999"><div align="center"><strong>CADASTRO LIMITE DE TEMPO</strong></div></td>
    </tr>
    <tr valign="baseline">
      <td width="43%" align="right" nowrap="nowrap"><div align="right">Desc:</div></td>
      <td width="57%"><input name="desc" type="text" class="imputTxt" id="sprytrigger2" value="" size="26" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><div align="center">
        <input type="submit" class="BnT" id="form1" value="Gravar" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<div class="tooltipContent" id="sprytooltip2">Descreva aqui o nome do grupo de tempo</div>
<table width="100%" border="0" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <th width="26%">ID</th>
    <th width="61%">Descrição</th>
    <th colspan="2">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_qr_tempo_grupo['id']; ?></td>
      <td><?php echo $row_qr_tempo_grupo['desc']; ?></td>
      <td width="4%"><a href="?pg=grupo_de_tempo&id=<?php echo $row_qr_tempo_grupo['id']; ?>"><img src="../imagens/kalarm.png" alt="" name="sprytrigger1" width="22" height="22" border="0" id="sprytrigger1" /></a></td>
      <td width="9%"><a href="?pg=edit_grupo_tempo&id=<?php echo $row_qr_tempo_grupo['id']; ?>"><img src="../imagens/botao_edit.png" name="sprytrigger3" width="16" height="16" border="0" id="sprytrigger3" /></a>&nbsp;&nbsp;<a href="javascript:confirmaExclusao('?pg=del_grupo_tempo&id=<?php echo $row_qr_tempo_grupo['id']; ?>')"><img src="../imagens/botao_drop.png" name="sprytrigger4" width="16" height="16" border="0" id="sprytrigger4" /></a></td>
    </tr>
    <?php } while ($row_qr_tempo_grupo = mysql_fetch_assoc($qr_tempo_grupo)); ?>
</table>
<div class="tooltipContent" id="sprytooltip4"><img src="../imagens/zoom.png" width="16" height="16" border="0" align="absmiddle" /> Apagar Grupo de Tempo</div>
<div class="tooltipContent" id="sprytooltip3">Editar Grupo de Tempo</div>
<div class="tooltipContent" id="sprytooltip1">Configurar regras do grupo de tempo</div>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_qr_tempo_grupo > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_tempo_grupo=%d%s", $currentPage, 0, $queryString_qr_tempo_grupo); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_tempo_grupo > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_tempo_grupo=%d%s", $currentPage, max(0, $pageNum_qr_tempo_grupo - 1), $queryString_qr_tempo_grupo); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_qr_tempo_grupo < $totalPages_qr_tempo_grupo) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_tempo_grupo=%d%s", $currentPage, min($totalPages_qr_tempo_grupo, $pageNum_qr_tempo_grupo + 1), $queryString_qr_tempo_grupo); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_qr_tempo_grupo < $totalPages_qr_tempo_grupo) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_tempo_grupo=%d%s", $currentPage, $totalPages_qr_tempo_grupo, $queryString_qr_tempo_grupo); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#sprytrigger3");
var sprytooltip4 = new Spry.Widget.Tooltip("sprytooltip4", "#sprytrigger4");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_tempo_grupo);
?>
