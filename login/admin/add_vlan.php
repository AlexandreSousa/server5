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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO v_lan (id, id_eth, v_lan_ip, mask) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_eth'], "text"),
                       GetSQLValueString($_POST['v_lan_ip'], "text"),
					   GetSQLValueString($_POST['mask'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  //Carregar arquivos para levantar as v-lan que esta na pasta firewall
  include "../firewall/up_vlan.php";
  echo "<meta http-equiv='refresh' content='0;URL=?pg=list_rede'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_lan = "SELECT * FROM rede";
$qr_lan = mysql_query($query_qr_lan, $Conexao) or die(mysql_error());
$row_qr_lan = mysql_fetch_assoc($qr_lan);
$totalRows_qr_lan = mysql_num_rows($qr_lan);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_vlan = "SELECT * FROM v_lan";
$qr_vlan = mysql_query($query_qr_vlan, $Conexao) or die(mysql_error());
$row_qr_vlan = mysql_fetch_assoc($qr_vlan);
$totalRows_qr_vlan = mysql_num_rows($qr_vlan);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de Redes Virtais</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="38%" align="right" nowrap="nowrap">Rede:</td>
      <td width="62%"><select name="id_eth">
        <?php 
do {  
?>
        <option value="<?php echo $row_qr_lan['eth']?>" ><?php echo $row_qr_lan['eth']?></option>
        <?php
} while ($row_qr_lan = mysql_fetch_assoc($qr_lan));
?>
      </select>
      Selecione a rede local      </td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IP-VLAN:</td>
      <td><input type="text" name="v_lan_ip" value="" size="32" />
        Coloque aqui o ip da rede virtual</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mascara:</td>
      <td><label>
        <select name="mask" id="mask">
          <option value="24">24</option>
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
          <option value="08">08</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="id" value="" size="32" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_lan);

mysql_free_result($qr_vlan);
?>
