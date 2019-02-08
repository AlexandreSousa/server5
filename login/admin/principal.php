<?php require_once('../Connections/Conexao.php'); ?>
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

$colname_qr_pedidos = "-1";
if (isset($_GET['situacao'])) {
  $colname_qr_pedidos = $_GET['situacao'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_pedidos = "SELECT * FROM pedidos WHERE situacao = 'aberto'";
$qr_pedidos = mysql_query($query_qr_pedidos, $Conexao) or die(mysql_error());
$row_qr_pedidos = mysql_fetch_assoc($qr_pedidos);
$totalRows_qr_pedidos = mysql_num_rows($qr_pedidos);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_logins = "SELECT * FROM usuarios";
$qr_logins = mysql_query($query_qr_logins, $Conexao) or die(mysql_error());
$row_qr_logins = mysql_fetch_assoc($qr_logins);
$totalRows_qr_logins = mysql_num_rows($qr_logins);

$colname_qr_c_receber = "-1";
if (isset($_GET['status'])) {
  $colname_qr_c_receber = $_GET['status'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_c_receber = sprintf("SELECT * FROM f_contas_receber WHERE status = 'aberto'", GetSQLValueString($colname_qr_c_receber, "text"));
$qr_c_receber = mysql_query($query_qr_c_receber, $Conexao) or die(mysql_error());
$row_qr_c_receber = mysql_fetch_assoc($qr_c_receber);
$totalRows_qr_c_receber = mysql_num_rows($qr_c_receber);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_logados = "SELECT * FROM logados";
$qr_logados = mysql_query($query_qr_logados, $Conexao) or die(mysql_error());
$row_qr_logados = mysql_fetch_assoc($qr_logados);
$totalRows_qr_logados = mysql_num_rows($qr_logados);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_radios = "SELECT * FROM inventario";
$qr_radios = mysql_query($query_qr_radios, $Conexao) or die(mysql_error());
$row_qr_radios = mysql_fetch_assoc($qr_radios);
$totalRows_qr_radios = mysql_num_rows($qr_radios);

$colname_qr_inventario01 = "-1";
if (isset($_GET['destino'])) {
  $colname_qr_inventario01 = $_GET['destino'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_inventario01 = sprintf("SELECT * FROM inventario WHERE destino = 'cliente'", GetSQLValueString($colname_qr_inventario01, "text"));
$qr_inventario01 = mysql_query($query_qr_inventario01, $Conexao) or die(mysql_error());
$row_qr_inventario01 = mysql_fetch_assoc($qr_inventario01);
$totalRows_qr_inventario01 = mysql_num_rows($qr_inventario01);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_inventario02 = "SELECT * FROM inventario WHERE destino = 'provedor'";
$qr_inventario02 = mysql_query($query_qr_inventario02, $Conexao) or die(mysql_error());
$row_qr_inventario02 = mysql_fetch_assoc($qr_inventario02);
$totalRows_qr_inventario02 = mysql_num_rows($qr_inventario02);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_livres = "SELECT * FROM hlivres";
$qr_livres = mysql_query($query_qr_livres, $Conexao) or die(mysql_error());
$row_qr_livres = mysql_fetch_assoc($qr_livres);
$totalRows_qr_livres = mysql_num_rows($qr_livres);
?><html>
  <head>
    <title></title>
    <meta content=""><style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
    </style>
    <link href="../css/tabelas.css" rel="stylesheet" type="text/css">
    <script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css"></head>
  <body>
  <table width="100%" border="0">
    <tr>
      <td background="../imagens/capa_fundo.png"><strong><span class="style1">SOLICITA&Ccedil;&Otilde;ES</span></strong></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="7%" class="linha_tabela"><strong>Usuario</strong></td>
          <td width="69%" class="linha_tabela"><strong>Solicita&ccedil;&atilde;o</strong></td>
          <td width="20%" class="linha_tabela"><strong>Situa&ccedil;&atilde;o</strong></td>
          <td width="4%" class="linha_tabela"><strong>A&ccedil;&atilde;o</strong></td>
        </tr>
        <?php do { ?>
          <tr>
            <td class="tabels_fundo"><?php $usua = $row_qr_pedidos['usuario']; 
			echo $usua;
			?></td>
            <td class="tabels_fundo"><?php echo $row_qr_pedidos['aviso']; ?></td>
            <td class="tabels_fundo"><?php echo $row_qr_pedidos['situacao']; ?></td>
            <td class="tabels_fundo"><div align="center"><img src="../imagens/apagar.gif" name="sprytrigger1" width="16" height="16" id="sprytrigger1"></div></td>
          </tr>
          <?php } while ($row_qr_pedidos = mysql_fetch_assoc($qr_pedidos)); ?>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="3" background="../imagens/capa_fundo.png"><span class="style1"><strong>SITUA&Ccedil;&Atilde;O ATUAL DO PROVEDOR</strong></span></td>
        </tr>
        <tr>
          <td width="30%" align="right" class="linha_tabela"><strong>Logins Cadastrados:</strong></td>
          <td width="17%" class="linha_tabela"><div align="center"><?php echo $totalRows_qr_logins ?> </div></td>
          <td width="53%" class="linha_tabela"><img src="../imagens/alerta2.gif" alt="" width="15" height="15"></td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Clientes Online Atualmente:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_logados ?></div></td>
          <td class="linha_tabela"><img src="../imagens/alerta2.gif" width="15" height="15"></td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Hosts Livres:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_livres ?> </div></td>
          <td class="linha_tabela"><img src="../imagens/alerta2.gif" alt="" width="15" height="15"></td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela">&nbsp;</td>
          <td class="linha_tabela"><div align="center"></div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left" background="../imagens/capa_fundo.png"><strong><span class="style1">FINACEIRO</span></strong></td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Contas Em Aberto:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_c_receber ?> </div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela">&nbsp;</td>
          <td class="linha_tabela"><div align="center"></div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left" background="../imagens/capa_fundo.png"><strong><span class="style1">iNVENTARIO</span></strong></td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Equipamentos de Clientes:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_inventario01 ?> </div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Equipamento Provedor:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_inventario02 ?> </div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" class="linha_tabela"><strong>Radios Cadastrados:</strong></td>
          <td class="linha_tabela"><div align="center"><?php echo $totalRows_qr_radios ?> </div></td>
          <td class="linha_tabela">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
  <div class="imputTxt" id="sprytooltip1"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle"> Encerrar o Pedido</div>  
  <script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
//-->
  </script>
</body>
</html>
<?php
mysql_free_result($qr_pedidos);

mysql_free_result($qr_logins);

mysql_free_result($qr_c_receber);

mysql_free_result($qr_logados);

mysql_free_result($qr_radios);

mysql_free_result($qr_inventario01);

mysql_free_result($qr_inventario02);

mysql_free_result($qr_livres);
?>