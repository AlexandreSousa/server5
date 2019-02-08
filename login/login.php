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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['nome'])) {
  $loginUsername=$_POST['nome'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "situacao";
  $MM_redirectLoginSuccess = "painel.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Conexao, $Conexao);
  	
  $LoginRS__query=sprintf("SELECT login, senha, situacao FROM usuarios WHERE login=%s AND senha=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Conexao) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'situacao');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="css/tabelas.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery-ui-1.js"></script>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="300" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF0000">
  <tr>
    <td width="296" height="150" align="center"><form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="100%" height="150" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF0000">
        <tr>
          <td width="290" height="41" align="left"><img src="imagens/fundo_login_top.jpg" width="300" height="33" /></td>
        </tr>
        <tr>
          <td height="88" align="center"><table width="200" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="45" align="right"><strong>Nome:</strong></td>
              <td width="155"><label>
                <input name="nome" type="text" class="campo" id="nome" size="10" />
              </label></td>
            </tr>
            <tr>
              <td align="right"><strong>Login:</strong></td>
              <td><label>
              <input name="senha" type="password" class="campo" id="senha" size="10" />
              </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><label>
                <input name="button" type="submit" class="ui-button ui-widget ui-state-default ui-corner-all" id="button" value="Enviar" />
              </label></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" align="center" bgcolor="#669999"><span class="style1">Uni&atilde;o Maker Desenvolvimentos</span></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
