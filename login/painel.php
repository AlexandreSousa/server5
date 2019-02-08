<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "a";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::::::::: Painel do Usuário :::::::</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="css/tabelas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="900" border="0" align="center">
  <tr>
    <td colspan="3" background="imagens/topo_user.png"><img src="imagens/topo_user.png" width="900" height="40" /></td>
  </tr>
  
  <tr>
    <td width="159" valign="top"><table width="100%" border="0">
      <tr>
        <td width="104" background="imagens/message_toolbar_tile.gif"><img src="imagens/agt_home.png" width="22" height="22" border="0" align="absmiddle" /> <a href="painel.php">Inicio</a></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/cadeado.gif" width="22" height="22" border="0" align="absmiddle" /> <a href="?pg=mudar_senha">Mudar Senha</a></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/advancedsettings.png" width="22" height="22" border="0" align="absmiddle" /> <a href="?pg=configuracao">Configurações</a></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/money_dollar.png" width="22" height="22" border="0" align="absmiddle" /> <a href="?pg=financeiro">Financeiro</a></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> <a href="?pg=grafico_de_cosumo">Graficos</a></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/funcionarios.jpg" width="22" height="22" border="0" align="absmiddle" /> Ajuda</td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><img src="imagens/finaliza.jpg" width="22" height="22" border="0" align="absmiddle" /> <a href="<?php echo $logoutAction ?>">Sair</a></td>
      </tr>
    </table></td>
    <td width="600" valign="top"><table width="100%" border="0" align="center">
      <tr>
        <td><?php include "query.php"; ?></td>
      </tr>
    </table></td>
    <td width="153" valign="top"><table width="153" border="0">
      <tr>
        <td width="127"><img src="imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /><span id="sprytrigger1"> Seja bem vindo</span></td>
      </tr>
      <tr>
        <td background="imagens/message_toolbar_tile.gif"><strong><img src="imagens/kuser.png" width="22" height="22" border="0" align="absmiddle" />          
            <?php $user = $_SESSION['MM_Username']; 
		echo $user; ?>		
          </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
        <td width="4%" background="imagens/message_toolbar_tile.gif">&nbsp;</td>
        <td width="60%" background="imagens/message_toolbar_tile.gif">&nbsp;</td>
        <td width="36%" align="right" background="imagens/message_toolbar_tile.gif"><img src="imagens/uniaomaker.png" width="80" height="15" /><img src="imagens/css.gif" width="80" height="15" /><img src="imagens/xhtml.gif" width="80" height="15" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
