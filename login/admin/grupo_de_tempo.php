<?php require_once('../Connections/Conexao.php'); ?>
<?php
$h1 = $_POST[h1];
$m1 = $_POST[m1];

$hora_inicio = "$h1:$m1";

$h2 = $_POST[h2];
$m2 = $_POST[m2];

$hora_final = "$h2:$m2";
$idd = $_GET[id];
?>
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
  $insertSQL = sprintf("INSERT INTO limite_tempo (id_grupo, dia, initio_h, fin_h, acao) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_grupo'], "text"),
                       GetSQLValueString($_POST['dia'], "text"),
                       GetSQLValueString($hora_inicio, "date"),
                       GetSQLValueString($hora_final, "date"),
                       GetSQLValueString($_POST['acao'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
    echo "<meta http-equiv='refresh' content='0;URL=?pg=grupo_de_tempo&id=$idd'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_tempo = "SELECT * FROM limite_tempo";
$qr_tempo = mysql_query($query_qr_tempo, $Conexao) or die(mysql_error());
$row_qr_tempo = mysql_fetch_assoc($qr_tempo);
$totalRows_qr_tempo = mysql_num_rows($qr_tempo);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_grupo = "SELECT * FROM grupo_tempo WHERE id = '$idd'";
$qr_grupo = mysql_query($query_qr_grupo, $Conexao) or die(mysql_error());
$row_qr_grupo = mysql_fetch_assoc($qr_grupo);
$totalRows_qr_grupo = mysql_num_rows($qr_grupo);

$maxRows_qr_plano_mostra = 10;
$pageNum_qr_plano_mostra = 0;
if (isset($_GET['pageNum_qr_plano_mostra'])) {
  $pageNum_qr_plano_mostra = $_GET['pageNum_qr_plano_mostra'];
}
$startRow_qr_plano_mostra = $pageNum_qr_plano_mostra * $maxRows_qr_plano_mostra;

$colname_qr_plano_mostra = "-1";
if (isset($_GET['id_grupo'])) {
  $colname_qr_plano_mostra = $_GET['id_grupo'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_plano_mostra = "SELECT * FROM limite_tempo WHERE id_grupo = '$idd'";
$query_limit_qr_plano_mostra = sprintf("%s LIMIT %d, %d", $query_qr_plano_mostra, $startRow_qr_plano_mostra, $maxRows_qr_plano_mostra);
$qr_plano_mostra = mysql_query($query_limit_qr_plano_mostra, $Conexao) or die(mysql_error());
$row_qr_plano_mostra = mysql_fetch_assoc($qr_plano_mostra);

if (isset($_GET['totalRows_qr_plano_mostra'])) {
  $totalRows_qr_plano_mostra = $_GET['totalRows_qr_plano_mostra'];
} else {
  $all_qr_plano_mostra = mysql_query($query_qr_plano_mostra);
  $totalRows_qr_plano_mostra = mysql_num_rows($all_qr_plano_mostra);
}
$totalPages_qr_plano_mostra = ceil($totalRows_qr_plano_mostra/$maxRows_qr_plano_mostra)-1;

$currentPage = $_SERVER["PHP_SELF"];

$queryString_qr_tempo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_qr_tempo") == false && 
        stristr($param, "totalRows_qr_tempo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_qr_tempo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_qr_tempo = sprintf("&totalRows_qr_tempo=%d%s", $totalRows_qr_tempo, $queryString_qr_tempo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="38%" align="right" nowrap="nowrap">Grupo:</td>
      <td width="15%"><label>
        <select name="id_grupo" class="imputTxt" id="id_grupo">
          <?php
do {  
?>
          <option value="<?php echo $row_qr_grupo['id']?>"><?php echo $row_qr_grupo['desc']?></option>
          <?php
} while ($row_qr_grupo = mysql_fetch_assoc($qr_grupo));
  $rows = mysql_num_rows($qr_grupo);
  if($rows > 0) {
      mysql_data_seek($qr_grupo, 0);
	  $row_qr_grupo = mysql_fetch_assoc($qr_grupo);
  }
?>
        </select>
      </label></td>
      <td width="47%" rowspan="6" valign="top"><div id="CollapsiblePanel1" class="CollapsiblePanel">
        <div class="CollapsiblePanelTab" tabindex="0">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" id="sprytrigger2">
          <tr>
            <td><span class="style1">
              <?php $limit =  $totalRows_qr_plano_mostra;
			
			?>
              <?php
          if ($limit >= 6){
		  echo "LIMITE ATINGIDO NÃO ADICIONE MAIS AGENDAMENTO";
		  }
		  else {
		  echo "ADICIONE MAIS AGENDAMENTO";
		  }
		  ?>
            </span></td>
          </tr>
        </table>
        <span class="style1">        </span></div>
        <div class="CollapsiblePanelContent">
          <table width="100%" border="0">
            
            <tr>
              <td width="27%" bgcolor="#999999"><strong>Dia</strong></td>
              <td width="26%" bgcolor="#999999"><strong>Inicio</strong></td>
              <td width="33%" bgcolor="#999999"><strong>Finao</strong></td>
              <td colspan="2" bgcolor="#999999"><strong>Ação</strong></td>
            </tr>
            <?php do { ?>
            <tr>
              <td class="tooltipContent"><?php $dia = $row_qr_plano_mostra['dia']; 
			echo $dia;
			?></td>
              <td class="tooltipContent"><?php $hi = $row_qr_plano_mostra['initio_h']; 
			echo $hi;
			?></td>
              <td class="tooltipContent"><?php $hf = $row_qr_plano_mostra['fin_h']; 
			echo $hf;
			?></td>
              <td width="7%" class="tooltipContent"><?php $ac = $row_qr_plano_mostra['acao']; 
			echo $ac;
			?></td>
              <td width="7%" align="center" class="tooltipContent"><a href="javascript:confirmaExclusao('?pg=dell_grupo_de_tempo&amp;id=<?php echo $row_qr_tempo['id']; ?>&amp;id_grupo=<?php echo $row_qr_plano_mostra['id_grupo']; ?>')"><img src="../imagens/botao_drop.png" alt="" name="sprytrigger1" width="16" height="16" border="0" id="sprytrigger1" /></a></td>
            </tr>
            <?php } while ($row_qr_plano_mostra = mysql_fetch_assoc($qr_plano_mostra)); ?>
          </table>
        </div>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dia:</td>
      <td><label>
        <select name="dia" class="imputTxt" id="dia">
          <option value="domingo">Domingo</option>
          <option value="segunda">Segunda</option>
          <option value="terca">Terça</option>
          <option value="quarta">Quarta</option>
          <option value="quinta">Quinta</option>
          <option value="sexta">Sexta</option>
          <option value="sabado">Sabado</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hora de Inicio:</td>
      <td><label>
        <select name="h1" class="imputTxt" id="h1">
          <option value="00">00</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
        </select>
      : 
      <select name="m1" class="imputTxt" id="m1">
        <option value="00">00</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
        <option value="32">32</option>
        <option value="33">33</option>
        <option value="34">34</option>
        <option value="35">35</option>
        <option value="36">36</option>
        <option value="37">37</option>
        <option value="38">38</option>
        <option value="39">39</option>
        <option value="40">40</option>
        <option value="41">41</option>
        <option value="42">42</option>
        <option value="43">43</option>
        <option value="44">44</option>
        <option value="45">45</option>
        <option value="46">46</option>
        <option value="47">47</option>
        <option value="48">48</option>
        <option value="49">49</option>
        <option value="50">50</option>
        <option value="51">51</option>
        <option value="52">52</option>
        <option value="53">53</option>
        <option value="54">54</option>
        <option value="55">55</option>
        <option value="56">56</option>
        <option value="57">57</option>
        <option value="58">58</option>
        <option value="59">59</option>
      </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hora Final:</td>
      <td><select name="h2" class="imputTxt" id="h2">
          <option value="00">00</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
        </select>
        : 
        <select name="m2" class="imputTxt" id="m2">
          <option value="00">00</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
          <option value="32">32</option>
          <option value="33">33</option>
          <option value="34">34</option>
          <option value="35">35</option>
          <option value="36">36</option>
          <option value="37">37</option>
          <option value="38">38</option>
          <option value="39">39</option>
          <option value="40">40</option>
          <option value="41">41</option>
          <option value="42">42</option>
          <option value="43">43</option>
          <option value="44">44</option>
          <option value="45">45</option>
          <option value="46">46</option>
          <option value="47">47</option>
          <option value="48">48</option>
          <option value="49">49</option>
          <option value="50">50</option>
          <option value="51">51</option>
          <option value="52">52</option>
          <option value="53">53</option>
          <option value="54">54</option>
          <option value="55">55</option>
          <option value="56">56</option>
          <option value="57">57</option>
          <option value="58">58</option>
          <option value="59">59</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ação:</td>
      <td><label>
        <select name="acao" class="imputTxt" id="acao">
          <option value="libera">Libera</option>
          <option value="negar">Negar</option>
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
<div class="imputTxt" id="sprytooltip2"><img src="../imagens/atraso.png" width="25" height="25" border="0" align="absmiddle" /> Esconder os agendamentos cadastrados</div>
<div class="imputTxt" id="sprytooltip1"><img src="../imagens/apagar.gif" width="16" height="16" border="0" align="absmiddle" /> Deletar agendamento</div>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_tempo);

mysql_free_result($qr_grupo);

mysql_free_result($qr_plano_mostra);
?>