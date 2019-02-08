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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET id_cliente=%s, mac=%s, id_esec=%s, id_auth=%s, situacao=%s, a_ip=%s, ip=%s, login=%s, senha=%s, proxy=%s, banda=%s, site=%s WHERE id=%s",
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
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($updateSQL, $Conexao) or die(mysql_error());
  
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
$idcli = $_POST['id'];

$colname_login2 = "-1";
if (isset($_GET['banda'])) {
  $colname_login2 = $_GET['banda'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_login2 = sprintf("SELECT * FROM usuarios WHERE id = '$idcli'", GetSQLValueString($colname_login2, "text"));
$login2 = mysql_query($query_login2, $Conexao) or die(mysql_error());
$row_login2 = mysql_fetch_assoc($login2);
$totalRows_login2 = mysql_num_rows($login2);

#Parametros para criação do aquivo de banda
$ind = $row_login2['id_cbq'];
$velo = $row_login2['login'];

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
  
  
  
     echo "<meta http-equiv='refresh' content='0;URL=?pg=h_livres'>";
}

$colname_edit_login = "-1";
if (isset($_GET['id'])) {
  $colname_edit_login = $_GET['id'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_edit_login = sprintf("SELECT * FROM usuarios WHERE id = %s", GetSQLValueString($colname_edit_login, "int"));
$edit_login = mysql_query($query_edit_login, $Conexao) or die(mysql_error());
$row_edit_login = mysql_fetch_assoc($edit_login);
$totalRows_edit_login = mysql_num_rows($edit_login);

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {font-size: 10px}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td height="26" colspan="4" align="center" nowrap="nowrap" background="../imagens/message_toolbar_tile.gif"><strong>Editar Login</strong></td>
    </tr>
    <tr valign="baseline">
      <td width="19%" rowspan="13" align="center" valign="top" nowrap="nowrap"><table width="200" border="0">
        <tr>
          <td align="center" background="../imagens/message_toolbar_tile.gif"><strong>Mensagen</strong></td>
        </tr>
        <tr>
          <td><?php echo $row_edit_login['msg']; ?></td>
        </tr>
      </table></td>
      <td width="17%" align="right" nowrap="nowrap"><strong>Id</strong>:</td>
      <td width="30%"><span class="style1"><?php echo $row_edit_login['id']; ?></span></td>
      <td width="34%" rowspan="14"><table width="38" border="0">
        <tr>
          <td width="32" align="center" valign="top"><span class="style2">
            <input name="image" type="image" / value="Insert record" src="../imagens/3floppy_unmount.png" />
            [Salvar]</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><a href="?pg=report_user&login=<?php echo $row_edit_login['login']; ?>"><img src="../imagens/vcalendar2.png" width="32" height="32" border="0" /><br />
              <span class="style2">[Relatorio]</span></a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><a href="?pg=add_msg&id=<?php echo $row_edit_login['id']; ?>"><img src="../imagens/irc_protocol.png" width="32" height="32" border="0" /><br />
              <span class="style2">[Mensagen</span></a><span class="style2">]</span></td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="../imagens/kspread_ksp.png" width="32" height="32" /><br />
            <span class="style2">[Financeiro]</span></td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Cliente:</td>
      <td><input type="text" name="id_cliente" value="<?php echo htmlentities($row_edit_login['id_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mac:</td>
      <td><input type="text" name="mac" value="<?php echo htmlentities($row_edit_login['mac'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo de Autenticação:</td>
      <td><label>
        <select name="id_auth" id="id_auth">
          <?php
do {  
?><option value="<?php echo $row_qr_auth['mod']?>"<?php if (!(strcmp($row_qr_auth['mod'], $row_edit_login['id_auth']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_auth['tipo']?></option>
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
        <select name="id_esec" id="id_esec">
          <?php
do {  
?><option value="<?php echo $row_qr_serial['hdalfa']?>"<?php if (!(strcmp($row_qr_serial['hdalfa'], $row_edit_login['id_esec']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qr_serial['login_u']?></option>
          <?php
} while ($row_qr_serial = mysql_fetch_assoc($qr_serial));
  $rows = mysql_num_rows($qr_serial);
  if($rows > 0) {
      mysql_data_seek($qr_serial, 0);
	  $row_qr_serial = mysql_fetch_assoc($qr_serial);
  }
?>
        </select>
        <?php echo $row_qr_serial['hdalfa']; ?></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Situação:</td>
      <td><select name="situacao">
        <option value="a" <?php if (!(strcmp("a", htmlentities($row_edit_login['situacao'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Ativo</option>
        <option value="b" <?php if (!(strcmp("b", htmlentities($row_edit_login['situacao'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Desativado</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ip Estatico:</td>
      <td><select name="a_ip" id="a_ip">
        <option value="sim" <?php if (!(strcmp("sim", $row_edit_login['a_ip']))) {echo "selected=\"selected\"";} ?>>Sim</option>
        <option value="nao" <?php if (!(strcmp("nao", $row_edit_login['a_ip']))) {echo "selected=\"selected\"";} ?>>Não</option>
        <?php
do {  
?>
        <option value="<?php echo $row_edit_login['a_ip']?>"<?php if (!(strcmp($row_edit_login['a_ip'], $row_edit_login['a_ip']))) {echo "selected=\"selected\"";} ?>><?php echo $row_edit_login['a_ip']?></option>
        <?php
} while ($row_edit_login = mysql_fetch_assoc($edit_login));
  $rows = mysql_num_rows($edit_login);
  if($rows > 0) {
      mysql_data_seek($edit_login, 0);
	  $row_edit_login = mysql_fetch_assoc($edit_login);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ip:</td>
      <td><input type="text" name="ip" value="<?php echo htmlentities($row_edit_login['ip'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Login:</td>
      <td><input type="text" name="login" value="<?php echo htmlentities($row_edit_login['login'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Senha:</td>
      <td><input type="text" name="senha" value="<?php echo htmlentities($row_edit_login['senha'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Proxy:</td>
      <td><select name="proxy">
        <option value="sim" <?php if (!(strcmp("sim", htmlentities($row_edit_login['proxy'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Sim</option>
        <option value="nao" <?php if (!(strcmp("nao", htmlentities($row_edit_login['proxy'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Não</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Banda:</td>
      <td><select name="banda">
        <?php 
do {  
?>
        <option value="<?php echo $row_qr_banda['id']?>" <?php if (!(strcmp($row_qr_banda['id'], htmlentities($row_edit_login['banda'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_qr_banda['desc']?></option>
        <?php
} while ($row_qr_banda = mysql_fetch_assoc($qr_banda));
?>
      </select>      </td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site:</td>
      <td><input type="text" name="site" value="<?php echo htmlentities($row_edit_login['site'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_edit_login['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_login);

mysql_free_result($qr_banda);

mysql_free_result($qr_auth);

mysql_free_result($qr_serial);
?>
