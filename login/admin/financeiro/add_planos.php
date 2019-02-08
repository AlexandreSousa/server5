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
  $insertSQL = sprintf("INSERT INTO f_planos (plano, descricao, valor, velocidade, velocidade_nominal, adesao, multa, website) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['plano'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['velocidade'], "text"),
                       GetSQLValueString($_POST['velocidade_nominal'], "text"),
                       GetSQLValueString($_POST['adesao'], "text"),
                       GetSQLValueString($_POST['multa'], "text"),
                       GetSQLValueString($_POST['website'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
}

$maxRows_qr_planos = 10;
$pageNum_qr_planos = 0;
if (isset($_GET['pageNum_qr_planos'])) {
  $pageNum_qr_planos = $_GET['pageNum_qr_planos'];
}
$startRow_qr_planos = $pageNum_qr_planos * $maxRows_qr_planos;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_planos = "SELECT * FROM f_planos";
$query_limit_qr_planos = sprintf("%s LIMIT %d, %d", $query_qr_planos, $startRow_qr_planos, $maxRows_qr_planos);
$qr_planos = mysql_query($query_limit_qr_planos, $Conexao) or die(mysql_error());
$row_qr_planos = mysql_fetch_assoc($qr_planos);

if (isset($_GET['totalRows_qr_planos'])) {
  $totalRows_qr_planos = $_GET['totalRows_qr_planos'];
} else {
  $all_qr_planos = mysql_query($query_qr_planos);
  $totalRows_qr_planos = mysql_num_rows($all_qr_planos);
}
$totalPages_qr_planos = ceil($totalRows_qr_planos/$maxRows_qr_planos)-1;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_banda = "SELECT * FROM banda";
$qr_banda = mysql_query($query_qr_banda, $Conexao) or die(mysql_error());
$row_qr_banda = mysql_fetch_assoc($qr_banda);
$totalRows_qr_banda = mysql_num_rows($qr_banda);

$queryString_qr_planos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_planos") == false && 
        stristr($param, "totalRows_qr_planos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_planos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_planos = sprintf("&totalRows_qr_planos=%d%s", $totalRows_qr_planos, $queryString_qr_planos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Financeiro Planos</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <td width="36%" align="right" nowrap="nowrap"><div align="right">Plano:</div></td>
      <td width="64%"><label>
        <select name="plano" class="imputTxt" id="plano">
          <option value="value">Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qr_banda['desc']?>"><?php echo $row_qr_banda['desc']?></option>
          <?php
} while ($row_qr_banda = mysql_fetch_assoc($qr_banda));
  $rows = mysql_num_rows($qr_banda);
  if($rows > 0) {
      mysql_data_seek($qr_banda, 0);
	  $row_qr_banda = mysql_fetch_assoc($qr_banda);
  }
?>
        </select>
      Selecione um Plano</label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Valor:</div></td>
      <td><input name="valor" type="text" class="imputTxt" id="valor" onkeypress="FormataValor(this.id, 10, event)" size="10" maxlength="10"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Velocidade:</div></td>
      <td><input name="velocidade" type="text" class="imputTxt" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Velocidade Nominal:</div></td>
      <td><div align="left">
          <input name="velocidade_nominal" type="text" class="imputTxt" value="" size="32" /> 
       (ex. 128kbps/64kbps)</div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Adesao:</div></td>
      <td><input name="adesao" type="text" class="imputTxt" id="adesao" onkeypress="FormataValor(this.id, 10, event)" value="200,00" size="10" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Multa:</div></td>
      <td><input name="multa" type="text" class="imputTxt" id="multa" onkeypress="FormataValor(this.id, 10, event)" value="0,50" size="10" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><div align="right">Descricao:</div></td>
      <td><textarea name="descricao" cols="28" rows="3" class="imputTxt" id="descricao"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="right">Website:</div></td>
      <td><label>
        <select name="website" id="website">
          <option value="Sim">Sim</option>
          <option value="nao">Não</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Insert record" /></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
  <table width="100%" border="1" class="tab1" id="tabela_exemplo">
    <tr>
      <th width="12%">Plano</th>
      <th width="12%">Valor</th>
      <th width="16%">Velocidade</th>
      <th width="11%">Velocidade Nominal</th>
      <th width="13%">Adesão</th>
      <th width="12%">Multa</th>
      <th width="14%">Website</th>
      <th colspan="2">Ações</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_qr_planos['plano']; ?></td>
        <td><?php echo $row_qr_planos['valor']; ?></td>
        <td><?php echo $row_qr_planos['velocidade']; ?></td>
        <td><?php $vn = $row_qr_planos['velocidade_nominal']; 
		echo $vn;
		?></td>
        <td><?php echo $row_qr_planos['adesao']; ?></td>
        <td><?php echo $row_qr_planos['multa']; ?></td>
        <td><?php echo $row_qr_planos['website']; ?></td>
        <td width="5%"><a href="?pg=financeiro/edit_plano&id=<?php echo $row_qr_planos['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
        <td width="5%"><a href="javascript:confirmaExclusao('?pg=financeiro/dell_planos&id=<?php echo $row_qr_planos['id']; ?>')"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
      </tr>
      <?php } while ($row_qr_planos = mysql_fetch_assoc($qr_planos)); ?>
  </table>
  <table border="0" align="center">
    <tr>
      <td><?php if ($pageNum_qr_planos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_planos=%d%s", $currentPage, 0, $queryString_qr_planos); ?>">First</a>
          <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_qr_planos > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_qr_planos=%d%s", $currentPage, max(0, $pageNum_qr_planos - 1), $queryString_qr_planos); ?>">Previous</a>
          <?php } // Show if not first page ?>
      </td>
      <td><?php if ($pageNum_qr_planos < $totalPages_qr_planos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_planos=%d%s", $currentPage, min($totalPages_qr_planos, $pageNum_qr_planos + 1), $queryString_qr_planos); ?>">Next</a>
          <?php } // Show if not last page ?>
      </td>
      <td><?php if ($pageNum_qr_planos < $totalPages_qr_planos) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_qr_planos=%d%s", $currentPage, $totalPages_qr_planos, $queryString_qr_planos); ?>">Last</a>
          <?php } // Show if not last page ?>
      </td>
    </tr>
  </table>
  <p><input type="hidden" name="MM_insert" value="form1" />
    </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_planos);

mysql_free_result($qr_banda);
?>
