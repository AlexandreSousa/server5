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
  $insertSQL = sprintf("INSERT INTO usuarios (id_cbq, id_cliente, mac, id_esec, id_auth, situacao, a_ip, ip, login, senha, proxy, banda, site, id_tempo, id_volume, cliente_f) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  					   GetSQLValueString($_POST['id_cbq'], "text"),
                       GetSQLValueString($_POST['id_cliente'], "text"),
                       GetSQLValueString($_POST['mac'], "text"),
					   GetSQLValueString($_POST['id_esec'], "text"),
					   GetSQLValueString($_POST['id_auth'], "text"),
					   GetSQLValueString($_POST['situacao'], "text"),
					   GetSQLValueString($_POST['a_ip'], "text"),
                       GetSQLValueString($_POST['ip'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['proxy'], "text"),
                       GetSQLValueString($_POST['banda'], "text"),
                       GetSQLValueString($_POST['site'], "text"),
					   GetSQLValueString($_POST['id_tempo'], "text"),
					   GetSQLValueString($_POST['id_volume'], "text"),
					   GetSQLValueString($_POST['cliente_f'], "text"));
					   
					   id_volume;

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  
    $bnd = $_POST['banda'];
  
  $colname_banda2 = "-1";
if (isset($_GET['id'])) {
  $colname_banda2 = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_banda2 = sprintf("SELECT * FROM banda WHERE id = '$bnd'", GetSQLValueString($colname_banda2, "int"));
$banda2 = mysql_query($query_banda2, $Conexao) or die(mysql_error());
$row_banda2 = mysql_fetch_assoc($banda2);
$totalRows_banda2 = mysql_num_rows($banda2);

$colname_rede_net = "-1";
if (isset($_GET['desc'])) {
  $colname_rede_net = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_rede_net = sprintf("SELECT * FROM rede WHERE `desc` = 'internet'", GetSQLValueString($colname_rede_net, "text"));
$rede_net = mysql_query($query_rede_net, $Conexao) or die(mysql_error());
$row_rede_net = mysql_fetch_assoc($rede_net);
$totalRows_rede_net = mysql_num_rows($rede_net);

$colname_rede_loc = "-1";
if (isset($_GET['desc'])) {
  $colname_rede_loc = $_GET['desc'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_rede_loc = sprintf("SELECT * FROM rede WHERE `desc` = 'local'", GetSQLValueString($colname_rede_loc, "text"));
$rede_loc = mysql_query($query_rede_loc, $Conexao) or die(mysql_error());
$row_rede_loc = mysql_fetch_assoc($rede_loc);
$totalRows_rede_loc = mysql_num_rows($rede_loc);

#Pega o logindo cliente baseado no id da banda cadastrada

$colname_login2 = "-1";
if (isset($_GET['banda'])) {
  $colname_login2 = $_GET['banda'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_login2 = sprintf("SELECT * FROM usuarios WHERE banda = '$bnd'", GetSQLValueString($colname_login2, "text"));
$login2 = mysql_query($query_login2, $Conexao) or die(mysql_error());
$row_login2 = mysql_fetch_assoc($login2);
$totalRows_login2 = mysql_num_rows($login2);

#Parametros para criação do aquivo de banda
$ind = $_POST['id_cbq'];


$velo = $_POST['login'];

#parametros para criação de limite de download
$redelocal = $row_rede_loc['eth'];
$bandad = $row_banda2['banda_down'];
$weigd = $row_banda2['div_down'];
$priod = $row_banda2['prio_down'];
$ruled = $_POST['ip'];

#Parametros para criação de limite de upload
$redenet = $row_rede_net['eth'];
$bandau = $row_banda2['banda_up'];
$weigu = $row_banda2['div_up'];
$priou = $row_banda2['prio_up'];
$ruleu = $_POST['ip'];

#Regras que cria o arquivo de download do CBQ
shell_exec ("sudo rm /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec ("sudo touch /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec ("sudo chmod 777 /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec("sudo echo  DEVICE=$redelocal,10Mbit,1Mbit > /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec("sudo echo  RATE=$bandad\kbit >> /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec("sudo echo  WEIGHT=$weigd\kbit >> /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec("sudo echo  PRIO=$priod >> /var/www/server/shaper/cbq-$ind.$velo.-in");
shell_exec("sudo echo  RULE=$ruled >> /var/www/server/shaper/cbq-$ind.$velo.-in");


#Regra que cria os arquivos de upload do CBQ
shell_exec ("sudo rm  /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec ("sudo touch /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec ("sudo chmod 777 /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec("sudo echo  DEVICE=$redenet,10Mbit,1Mbit > /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec("sudo echo  RATE=$bandau\kbit >> /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec("sudo echo  WEIGHT=$weigu\kbit >> /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec("sudo echo  PRIO=$priou >> /var/www/server/shaper/cbq-$ind.$velo.-up");
shell_exec("sudo echo  RULE=$ruled >> /var/www/server/shaper/cbq-$ind.$velo.-up");

  shell_exec("sudo /etc/init.d/shaper stop 2>&1 1> /dev/null");
  shell_exec("sudo /etc/init.d/shaper start 2>&1 1> /dev/null");
  
  
  
   echo "<meta http-equiv='refresh' content='0;URL=?pg=list_login'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_login = "SELECT * FROM usuarios";
$qr_login = mysql_query($query_qr_login, $Conexao) or die(mysql_error());
$row_qr_login = mysql_fetch_assoc($qr_login);
$totalRows_qr_login = mysql_num_rows($qr_login);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_banda = "SELECT * FROM banda";
$qr_banda = mysql_query($query_qr_banda, $Conexao) or die(mysql_error());
$row_qr_banda = mysql_fetch_assoc($qr_banda);
$totalRows_qr_banda = mysql_num_rows($qr_banda);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_auth = "SELECT * FROM auth_tipe";
$qr_auth = mysql_query($query_qr_auth, $Conexao) or die(mysql_error());
$row_qr_auth = mysql_fetch_assoc($qr_auth);
$totalRows_qr_auth = mysql_num_rows($qr_auth);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_serial = "SELECT * FROM esec";
$qr_serial = mysql_query($query_qr_serial, $Conexao) or die(mysql_error());
$row_qr_serial = mysql_fetch_assoc($qr_serial);
$totalRows_qr_serial = mysql_num_rows($qr_serial);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_volume = "SELECT * FROM banwidth";
$qr_volume = mysql_query($query_qr_volume, $Conexao) or die(mysql_error());
$row_qr_volume = mysql_fetch_assoc($qr_volume);
$totalRows_qr_volume = mysql_num_rows($qr_volume);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_tempo = "SELECT * FROM grupo_tempo";
$qr_tempo = mysql_query($query_qr_tempo, $Conexao) or die(mysql_error());
$row_qr_tempo = mysql_fetch_assoc($qr_tempo);
$totalRows_qr_tempo = mysql_num_rows($qr_tempo);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td colspan="3" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Cadastro de Logins</strong></td>
    </tr>
    
    <tr valign="baseline">
      <td width="40%" align="right" nowrap="nowrap">Id Cliente:</td>
      <td width="21%"><input type="text" name="id_cliente" value="0" size="10" />
      <input name="id_cbq" type="hidden" id="id_cbq" value="<?php include 'randon.php'; ?>" /></td>
      <td width="39%" rowspan="9" valign="top"><table width="38" border="0">
        <tr>
          <td width="32" align="center" valign="top"><span class="style2">
            <input name="image" type="image" / value="Insert record" src="../imagens/3floppy_unmount.png" />
            [Salvar]</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        
        
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        
      </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mac:</td>
      <td><input type="text" name="mac" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo de Autenticação:</td>
      <td><label>
        <select name="id_auth" id="id_auth">
          <?php
do {  
?><option value="<?php echo $row_qr_auth['mod']?>"<?php if (!(strcmp($row_qr_auth['mod'], $row_banda2['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_auth['tipo']?></option>
          <?php
} while ($row_qr_auth = mysql_fetch_assoc($qr_auth));
  $rows = mysql_num_rows($qr_auth);
  if($rows > 0) {
      mysql_data_seek($qr_auth, 0);
	  $row_qr_auth = mysql_fetch_assoc($qr_auth);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Serial:</td>
      <td><label>
        <select name="login_u" id="login_u">
          <option value="0">Selecione</option>
          <?php
do {  
?><option value="<?php echo $row_qr_serial['hdalfa']?>"><?php echo $row_qr_serial['login_u']?></option>
          <?php
} while ($row_qr_serial = mysql_fetch_assoc($qr_serial));
  $rows = mysql_num_rows($qr_serial);
  if($rows > 0) {
      mysql_data_seek($qr_serial, 0);
	  $row_qr_serial = mysql_fetch_assoc($qr_serial);
  }
?>
                </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Situação:</td>
      <td><label>
        <select name="situacao" id="situacao">
          <option value="a">Ativado</option>
          <option value="b">Desativado</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ip Estatico:</td>
      <td><label>
        <select name="a_ip" id="a_ip">
          <option value="sim">Sim</option>
          <option value="nao">Não</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ip Do Cliente:</td>
      <td><input type="text" name="ip" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Login:</td>
      <td><input type="text" name="login" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Senha:</td>
      <td><input type="text" name="senha" value="" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Controle de Banda e Proxy</strong></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Proxy:</td>
      <td><select name="proxy">
        <option value="sim" <?php if (!(strcmp("sim", ""))) {echo "SELECTED";} ?>>Sim</option>
        <option value="nao" <?php if (!(strcmp("nao", ""))) {echo "SELECTED";} ?>>
    Não    </option>
    
</select></td>
      <td>&nbsp;</td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda:</td>
      <td><select name="banda">
          <option value="null">Nenhum</option>
          <?php
do {  
?><option value="<?php echo $row_qr_banda['id']?>"><?php echo $row_qr_banda['desc']?></option>
          <?php
} while ($row_qr_banda = mysql_fetch_assoc($qr_banda));
  $rows = mysql_num_rows($qr_banda);
  if($rows > 0) {
      mysql_data_seek($qr_banda, 0);
	  $row_qr_banda = mysql_fetch_assoc($qr_banda);
  }
?>
      </select>      </td>
      <td>&nbsp;</td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site:</td>
      <td><input type="text" name="site" value="" size="32" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <th colspan="3" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif">Controle de Volume e Tempo</th>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Controle de Tempo:</td>
      <td><label>
        <select name="id_tempo" id="id_tempo">
          <option value="0">Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qr_tempo['id']?>"><?php echo $row_qr_tempo['desc']?></option>
          <?php
} while ($row_qr_tempo = mysql_fetch_assoc($qr_tempo));
  $rows = mysql_num_rows($qr_tempo);
  if($rows > 0) {
      mysql_data_seek($qr_tempo, 0);
	  $row_qr_tempo = mysql_fetch_assoc($qr_tempo);
  }
?>
        </select>
      </label></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Controle de Volume:</td>
      <td><label>
        <select name="id_volume" id="id_volume">
          <option value="0">Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qr_volume['id']?>"><?php echo $row_qr_volume['tipo']?></option>
          <?php
} while ($row_qr_volume = mysql_fetch_assoc($qr_volume));
  $rows = mysql_num_rows($qr_volume);
  if($rows > 0) {
      mysql_data_seek($qr_volume, 0);
	  $row_qr_volume = mysql_fetch_assoc($qr_volume);
  }
?>
        </select>
      </label></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Financeiro</strong></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sistema de Cobrança:</td>
      <td><label>
        <select name="cliente_f" id="cliente_f">
          <option value="Cobra">cobra</option>
          <option value="Bloquear">bloquear</option>
        </select>
      </label></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($qr_login);

mysql_free_result($qr_banda);

mysql_free_result($qr_auth);

mysql_free_result($qr_serial);

mysql_free_result($qr_volume);

mysql_free_result($qr_tempo);

?>
