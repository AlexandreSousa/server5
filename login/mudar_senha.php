<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>



<script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<link href="css/tabelas.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="?pg=mudar_senha_db">
  <table width="100%" border="0" align="center">
    
    <tr>
      <td width="38%" align="right">Senha Atual:</td>
      <td width="62%"><span id="sprytextfield1">
        <input name="senha_atual" type="text" class="imputTxt" id="senha_atual" />
      <span class="textfieldRequiredMsg"><br />Senha atual e obrigatorio!.</span></span>
      <label>
      <input name="usuario" type="hidden" id="usuario" value="<?php $user = $_SESSION['MM_Username']; 
		echo $user; ?>" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Nova Senha:</td>
      <td><label>
        <input name="nova_senha" type="text" class="imputTxt" id="nova_senha" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Repita a Nova Senha</td>
      <td><label>
        <input name="repita_senha" type="text" class="imputTxt" id="repita_senha" />
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><label>
        <input name="button" type="submit" class="BnT" id="button" value="Mudar Senha" />
      </label></td>
    </tr>
  </table>
</form>

<div class="imputTxt" id="sprytooltip3"><img src="imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Digite a Senha Atual!</div>
<div class="imputTxt" id="sprytooltip2"><img src="imagens/cadeado.gif" width="22" height="22" border="0" align="absmiddle" />Digite Novemente a Senha!</div>
<div class="imputTxt" id="sprytooltip1"><img src="imagens/cadeado.gif" width="22" height="22" border="0" align="absmiddle" />Digite a Nova Senha!</div>
<script type="text/javascript">
<!--
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#nova_senha");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#repita_senha");
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#senha_atual");
//-->
</script>
</body>
</html>
