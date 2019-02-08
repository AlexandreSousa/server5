<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MyRouter - Suporte</title>
<link href="../../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="?pg=financeiro/buscar">
  <table width="100%" border="0" align="center" id="tabela2">
    <tr>
      <td colspan="4" background="img/message_toolbar_tile.gif"><strong>Selecione um Usuário</strong></td>
    </tr>
    <tr>
      <td width="363"><div align="right">Usuário:</div></td>
      <td width="152"><input type="text" name="campo" id="campo" /></td>
      <td width="59" align="right">      <div align="right">Campo:</div></td>
      <td width="422"><label>
        <select name="tabela" id="tabela">
          <option value="nome">Nome</option>
          <option value="cpfcnpj">CPF/CNPJ</option>
          <option value="ofone">Telefone</option>
          <option value="endereco">Endereço</option>
        </select>
      </label></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="51%">&nbsp;</td>
      <td width="49%"><input type="submit" name="Enviar" id="Enviar" value="Enviar" /></td>
    </tr>
  </table>
  </form>
</body>
</html>