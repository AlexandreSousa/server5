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

$colname_qr_aviso = "-1";
if (isset($_GET['taget'])) {
  $colname_qr_aviso = $_GET['taget'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_aviso = sprintf("SELECT * FROM aviso WHERE taget = 'geral'", GetSQLValueString($colname_qr_aviso, "text"));
$qr_aviso = mysql_query($query_qr_aviso, $Conexao) or die(mysql_error());
$row_qr_aviso = mysql_fetch_assoc($qr_aviso);
$totalRows_qr_aviso = mysql_num_rows($qr_aviso);
?>
<?php  require_once('config.php'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AUTENTICA&Ccedil;&Atilde;O - <?php echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Language" content="pt-br" />
<meta http-equiv="Cache-Control" content="no-cache, no-store" />
<meta http-equiv="Pragma" content="no-cache, no-store" />
<meta http-equiv="expires" content="Mon, 06 Jan 1990 00:00:01 GMT" />
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
body {
	background-color: #FFFFFF;
	margin: 0px;
}
a {
	color: #333333;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: underline;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #333333;
}
.form_login {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	border: 1px solid #024EBF;
	height: 18px;
	width: 180px;
}
.form_btn {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}		
.login-destaque {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.login {
	font-size: 10px;
	font-weight: bold;	
	color: #FFFFFF;
}
.menu {
	font-size: 10px;
	color:#333333;
}
.erro {
	font-size: 10px;
	color: #FF0000;
}
.destaque {
        font-size: 10px;
        color: #0000CC;
}
.style1 {
	color: #0000FF
}
.style2 {
	color: #0000FF;
	font-size: 18px;
	font-weight: bold;
}
#pisca {
	text-decoration: blink;
}
.style3 {font-size: 24px}
-->
</style>

<script language="javascript" type="text/javascript">
function authlogin()
{
 var login = document.autenticar.login.value
 var senha = document.autenticar.senha.value
 if(login=="")
 {
 alert("E necessario o preenchimento dos seguintes campos:\n- Usuario\n- Senha.");
 document.autenticar.login.focus();
 return false
 }
 if(senha=="")
 {
 alert("E necessario o preenchimento dos seguintes campos:\n- Usuario\n- Senha.");
 document.autenticar.senha.focus();
 return false
 }
}
</script>

</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="20">
  <tr>
    <td align="center" valign="middle"><table width="100%" border="0">
      <tr>
        <td><img src="../../imagens/config4.png" width="222" height="76" border="0"></td>
        <td>&nbsp;</td>
        <td align="right"><img src="../../imagens/config5.png" width="301" height="76" border="0"></td>
      </tr>
    </table>
      <p class="style2 style3" id="pisca"><?php echo $row_qr_aviso['aviso']; ?></p>
      <p class="erro">
        <?php  

    # Pega a mensagem de erro enviada pela url
	$ERRO = $_GET['erro']; 
	     
	# Exibi a mensagem de erro
	if ( $ERRO == login )
	   { echo 'Usu&aacute;rio inexistente ou incorreto, por favor verifique se a tecla Caps Lock de seu teclado esta pressionada.';
	   }
        if ( $ERRO == senha )
           { echo 'Senha incorreta, por favor verifique se a tecla Caps Lock de seu teclado esta pressionada.';
           }
        if ( $ERRO == config )
           { echo "As configura&ccedil;&otilde;es de acesso de seu computador n&atilde;o conferem com as cadastradas em nosso sistema, por favor entre em contato conosco clicando no link abaixo Atendimento On-line, ou pelo telefone $telefone.";
           }
        if ( $ERRO == block )
           { echo "<b>SISTEMA BLOQUEADO</b> <br> Mensalidades em aberto, por favor entre em contato conosco clicando no link abaixo Atendimento On-line, ou pelo telefone $telefone.";
           }

	?>
        <?php

        // Pega a mensagem de erro enviada pela url
        $FIM = $_GET['logout'];

        // Exibi a mensagem de fim de conexao
        if ( $FIM == sim )
           { echo 'Conex&atilde;o finalizada com sucesso.';
           }

	?>
      </p>
      <p class="erro">SUPORTE T&Eacute;CNICO</p>
      <table width="290" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3"><img src="../../imagens/login_top.jpg" width="291" height="20"></td>
        </tr>
        <tr>
          <td width="6" background="../../imagens/login_le.jpg">&nbsp;</td>
          <td align="center" valign="top" background="../../imagens/login_bg.jpg">
		  <form action="../../auth.php" method="post" name="autenticar" id="autenticar">
	        <table width="270" border="0" cellspacing="2" cellpadding="0">
	        <tr>
	          <td height="30" colspan="2" align="center" valign="top" class="login-destaque">Acessar a internet, login: </td>
	          </tr>
	        <tr>
	          <td width="75" height="20" align="right" class="login">Usu&aacute;rio: </td>
	          <td width="225" align="left"><input name="login" type="text" class="form_login" id="login" size="30" maxlength="30" /></td>
	        </tr>
	        <tr>
	          <td height="20" align="right" class="login">Senha: </td>
	          <td align="left"><input name="senha" type="password" class="form_login" id="senha" size="30" maxlength="30" /></td>
	        </tr>
	        <tr>
			  <td>
	           <input name="site" type="hidden" id="site" value="<? echo $_REQUEST['url'] ?>" /></td>
	          <td height="25" align="left"><input name="Submit" type="submit" class="form_btn" value="Conectar" onClick="return authlogin()" /></td>
	        </tr>
	        <tr>
	          <td height="25" colspan="2" align="center"><a href="painel.php"><img src="../../imagens/agt_forum.png" width="22" height="22" border="0" align="absmiddle"> [painel de controle]</a></td>
	          </tr>
	      </table>
    	  </form>		  </td>
          <td width="6" background="../../imagens/login_ld.jpg">&nbsp;</td>
        </tr>
        <tr>
          <td height="10" colspan="3"><img src="../../imagens/login_base.jpg" width="291" height="10"></td>
        </tr>
      </table>
      <p class="erro">LEMBRE-SE: sua senha &eacute; de uso pessoal. Tudo o que 
        for feito com o uso dela &eacute; de sua inteira responsabilidade.</p>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($qr_aviso);
?>
