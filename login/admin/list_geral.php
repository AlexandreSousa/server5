<?php require_once('../Connections/Conexao.php'); ?>
<?php

$datainicial = $_POST["data"];
$datafinal = $_POST["data_final"];

$datainicial = substr($datainicial,6,4)."-".substr($datainicial,3,2)."-".substr($datainicial,0,2);
$datafinal = substr($datafinal,6,4)."-".substr($datafinal,3,2)."-".substr($datafinal,0,2);
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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_sessao = "SELECT * FROM sessao WHERE data = '$datainicial'";
$qr_sessao = mysql_query($query_qr_sessao, $Conexao) or die(mysql_error());
$row_qr_sessao = mysql_fetch_assoc($qr_sessao);
$totalRows_qr_sessao = mysql_num_rows($qr_sessao);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />

<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php

	include "../libchart/libchart/classes/libchart.php";
	$user = $_SESSION['MM_Username'];
	
	$comando = "SELECT * FROM sessao WHERE data = '$datainicial'";
	$sql = mysql_query($comando);

	$chart = new VerticalBarChart();

	$dataSet = new XYDataSet();
	$linhas = mysql_num_rows($sql);
	for($i=0;$i<$linhas;$i++){
	$down = mysql_result($sql,$i,'down');
	$data = mysql_result($sql,$i,'up');
	$user = mysql_result($sql,$i,'login');
	
	$dataSet->addPoint(new Point("$user", $down,$up));
	
	}
	$chart->setDataSet($dataSet);

	$chart->setTitle("Gerado por www.uniaomaker.com.br");
	$chart->render("../libchart/demo/generated/demo$datainicial.png");
?>
<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">
  <img src="../imagens/grafico.png" width="22" height="22" border="0" align="absmiddle" /> Download</div>
  <div class="CollapsiblePanelContent"><img alt="Vertical bars chart" src="../libchart/demo/generated/demo<?php echo $datainicial; ?>.png" style="border: 1px solid gray;"/></div>
</div>

<?php

	include "../libchart/libchart/classes/libchart.php";
	$user = $_SESSION['MM_Username'];
	
	$comando = "SELECT * FROM sessao WHERE data = '$datainicial'";
	$sql = mysql_query($comando);

	$chart = new VerticalBarChart();

	$dataSet = new XYDataSet();
	$linhas = mysql_num_rows($sql);
	for($i=0;$i<$linhas;$i++){
	$up = mysql_result($sql,$i,'up');
	$data = mysql_result($sql,$i,'data');
	$user = mysql_result($sql,$i,'login');
	
	$dataSet->addPoint(new Point("$user", $up));
	
	}
	$chart->setDataSet($dataSet);

	$chart->setTitle("Gerado por www.uniaomaker.com.br");
	$chart->render("../libchart/demo/generated/demoup$datainicial.png");
?>

<div id="CollapsiblePanel2" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0"><img src="../imagens/grafico.png" width="22" height="22" border="0" align="absmiddle" /> Upload</div>
  <div class="CollapsiblePanelContent"><img alt="Vertical bars chart" src="../libchart/demo/generated/demoup<?php echo $datainicial; ?>.png" style="border: 1px solid gray;"/></div>
</div>
<table width="100%" border="0" align="center" id="tabela2">
  <tr>
    <th width="3%">id</th>
    <th width="12%">login</th>
    <th width="26%">ip</th>
    <th width="21%">down</th>
    <th width="18%">up</th>
    <th width="20%">data</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php $id = $row_qr_sessao['id'];
	  echo $id;
	   ?></td>
      <td><?php $login = $row_qr_sessao['login']; 
	  echo $login
	  ?></td>
      <td><div align="center"><?php echo $row_qr_sessao['ip']; ?></div></td>
      <td><?php echo colores($row_qr_sessao['down'], 3); ?></td>
      <td><?php echo colores($row_qr_sessao['up'], 3); ?></td>
      <td align="center"><div align="center">
        <?php $data = $row_qr_sessao['data']; 
	  $data = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
	  echo $data;
	  
	  ?>
      </div></td>
    </tr>
    <?php } while ($row_qr_sessao = mysql_fetch_assoc($qr_sessao)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Total:</strong></div></td>
    <td>
    <?php

//$sql = mysql_query ("SELECT SUM(down) as down FROM sessao WHERE login = '$login"); 
//$sql = mysql_query ("select sum(down) as down from sessao group by down having login='$login'");
$sql2 = mysql_query ("SELECT sum(down) as down FROM sessao WHERE data = '$datainicial'"); 
$linhas = mysql_num_rows($sql2);

for($i=0;$i<$linhas;$i++){
	
	$down =  mysql_result($sql2,$i,'down');

	
	echo colores($down, 3);
	}
	?>    </td>
    <td>
    <?php

$sql = mysql_query ("SELECT sum(down) as down,sum(up) as up FROM sessao WHERE data = '$datainicial'"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
	$up =  mysql_result($sql,$i,'up');
	

	
	echo colores($up, 3);
	}
	?>    </td>
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>

<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($qr_sessao);
?>
