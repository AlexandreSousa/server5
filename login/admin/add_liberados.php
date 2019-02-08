<?php require_once('../Connections/Conexao.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO squi_liebados (liberados) VALUES (%s)",
                       GetSQLValueString($_POST['liberados'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  echo "<p align='center'><strong>Cadastrado com Sucesso</strong></p>";
  include "liberados_sql.php";
}

$maxRows_qr_liberados = 10;
$pageNum_qr_liberados = 0;
if (isset($_GET['pageNum_qr_liberados'])) {
  $pageNum_qr_liberados = $_GET['pageNum_qr_liberados'];
}
$startRow_qr_liberados = $pageNum_qr_liberados * $maxRows_qr_liberados;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_liberados = "SELECT * FROM squi_liebados";
$query_limit_qr_liberados = sprintf("%s LIMIT %d, %d", $query_qr_liberados, $startRow_qr_liberados, $maxRows_qr_liberados);
$qr_liberados = mysql_query($query_limit_qr_liberados, $Conexao) or die(mysql_error());
$row_qr_liberados = mysql_fetch_assoc($qr_liberados);

if (isset($_GET['totalRows_qr_liberados'])) {
  $totalRows_qr_liberados = $_GET['totalRows_qr_liberados'];
} else {
  $all_qr_liberados = mysql_query($query_qr_liberados);
  $totalRows_qr_liberados = mysql_num_rows($all_qr_liberados);
}
$totalPages_qr_liberados = ceil($totalRows_qr_liberados/$maxRows_qr_liberados)-1;

$ip = $row_qr_liberados['liberados'];



$queryString_qr_liberados = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_liberados") == false && 
        stristr($param, "totalRows_qr_liberados") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_liberados = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_liberados = sprintf("&totalRows_qr_liberados=%d%s", $totalRows_qr_liberados, $queryString_qr_liberados);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language='javascript'>
function confirmaExclusao(aURL) {
if(confirm('Você tem certeza que deseja excluir?')) {
location.href = aURL;
}
}
</script>
<style type="text/css">
<!--
-->
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center" id="tabela2">
    <tr valign="baseline">
      <th colspan="2" background="../imagens/message_toolbar_tile.gif">Cadastro de IP</th>
    </tr>
    <tr valign="baseline">
      <td width="39%" align="right" nowrap="nowrap"><div align="right">Liberados:</div></td>
      <td width="61%"><input name="liberados" type="text" class="imputTxt" value="" size="15" /> 
        <span class="style1">Coloque aqui o ip o qual deseja libera acesso toral </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><div align="center">
        <input type="submit" class="BnT" value="Gravar" />
      </div></td>
    </tr>
  </table>
  <p><input type="hidden" name="MM_insert" value="form1" />
    </p>
</form>
<table width="100%" border="0" align="center" class="tab1" id="tabela_exemplo">
  <tr>
    <th colspan="5" background="../imagens/message_toolbar_tile.gif"><div align="center" class="style3">Lista de Clientes Com Acesso Liberados</div></th>
  </tr>
  <tr>
    <th>IP</th>
    <th>Login</th>
    <th colspan="3">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td width="23%" align="center"><?php $ip3 = $row_qr_liberados['liberados'];
	  echo $ip3;
	   ?></td>
      <td width="70%" align="center"><?php 
	  $colname_qr_login = "-1";
if (isset($_GET['ip'])) {
  $colname_qr_login = $_GET['ip'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_login = sprintf("SELECT * FROM usuarios WHERE ip = '$ip3'", GetSQLValueString($colname_qr_login, "text"));
$qr_login = mysql_query($query_qr_login, $Conexao) or die(mysql_error());
$row_qr_login = mysql_fetch_assoc($qr_login);
$totalRows_qr_login = mysql_num_rows($qr_login); 
echo $row_qr_login['login'];
?></td>
      <td width="4%" align="center"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></td>
      <td width="3%" colspan="2"><a href="?pg=del_liberados&id=<?php echo $row_qr_liberados['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
    </tr>
    <?php } while ($row_qr_liberados = mysql_fetch_assoc($qr_liberados)); ?>
<tr>
    <th colspan="5" align="center"> Registro <span class="style1 style2"><?php echo $totalRows_qr_liberados ?></span> Pagina  <span class="style1 style2"><?php echo ($startRow_qr_liberados + 1) ?></span> Mostrando <span class="style1"><?php echo min($startRow_qr_liberados + $maxRows_qr_liberados, $totalRows_qr_liberados) ?></span> de <span class="style1"><?php echo $totalRows_qr_liberados ?></span> &nbsp;
<table border="0">
        <tr>
          <td><?php if ($pageNum_qr_liberados > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_qr_liberados=%d%s", $currentPage, 0, $queryString_qr_liberados); ?>">First</a>
              <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_qr_liberados > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_qr_liberados=%d%s", $currentPage, max(0, $pageNum_qr_liberados - 1), $queryString_qr_liberados); ?>">Previous</a>
              <?php } // Show if not first page ?>          </td>
          <td><?php if ($pageNum_qr_liberados < $totalPages_qr_liberados) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_qr_liberados=%d%s", $currentPage, min($totalPages_qr_liberados, $pageNum_qr_liberados + 1), $queryString_qr_liberados); ?>">Next</a>
              <?php } // Show if not last page ?>          </td>
          <td><?php if ($pageNum_qr_liberados < $totalPages_qr_liberados) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_qr_liberados=%d%s", $currentPage, $totalPages_qr_liberados, $queryString_qr_liberados); ?>">Last</a>
              <?php } // Show if not last page ?>          </td>
        </tr>
      </table></th>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_liberados);


mysql_free_result($qr_login);
?>
