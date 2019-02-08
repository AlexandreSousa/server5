<?php require_once('Connections/Conexao.php'); ?>
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

mysql_select_db($database_Conexao, $Conexao);
$query_qr_parametros = "SELECT * FROM parametros";
$qr_parametros = mysql_query($query_qr_parametros, $Conexao) or die(mysql_error());
$row_qr_parametros = mysql_fetch_assoc($qr_parametros);
$totalRows_qr_parametros = mysql_num_rows($qr_parametros);

$colname_qr_iface_net = "-1";
if (isset($_GET['desc'])) {
  $colname_qr_iface_net = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_iface_net = sprintf("SELECT * FROM rede WHERE `desc` = 'internet'", GetSQLValueString($colname_qr_iface_net, "text"));
$qr_iface_net = mysql_query($query_qr_iface_net, $Conexao) or die(mysql_error());
$row_qr_iface_net = mysql_fetch_assoc($qr_iface_net);
$totalRows_qr_iface_net = mysql_num_rows($qr_iface_net);


$site = $row_qr_parametros['site'];
$ip1 = $row_qr_parametros['ip1'];
$ip2 = $row_qr_parametros['ip2'];
$ip3 = $row_qr_parametros['ip3'];
$ip4 = $row_qr_parametros['ip4'];
$p_proxy = $row_qr_parametros['p_proxy'];
$ffone = $row_qr_parametros['fone'];
$ttime = $row_qr_parametros['time'];

//Interface de rede de internet 
//usada para definir regra de firewall de compartilhamento

$ifnet = $row_qr_iface_net['eth'];

// Coloque o endereço IP da interface do servidor conectada a intranet 
$servidor = "$ip1.$ip2.$ip3.$ip4";
$ip_route = "$ip1.$ip2.$ip3.0";
// Porta do Proxy Squid (Porta padrão 3128)
$squid = $p_proxy;

// Site do provedor ou site de destino do cliente
$siteprovedor = $site;

// Telefone do Provedor
$telefone = $ffone;

// Titulo da Pagina de Login
$titulo = 'Internet sem limites';

//Limite de Espera de Redirecionamento

$redir = $ttime;


mysql_free_result($qr_iface_net);
?>