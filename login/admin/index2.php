<?php include "chk.php"; ?>
<?php include "../class/data_class.php"; ?>
<?php include ('../class/global.class.php');?>
<?php include ('../class/funcoes.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Server 5 - www.uniaomaker.com.br</title>

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
.borda {
	border: 1px solid #FF0000;
}
-->
</style>
<style type="text/css">
    thead th {
        background: #f90;
    }
 
    .odd {
        background: #ffb;
    }
</style>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="../class/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../class/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="../js/jquery.js"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function FormataValor(id,tammax,teclapres) {
    
        if(window.event) { // Internet Explorer
         var tecla = teclapres.keyCode; }
        else if(teclapres.which) { // Nestcape / firefox
         var tecla = teclapres.which;
        }
    

vr = document.getElementById(id).value;
vr = vr.toString().replace( "/", "" );
vr = vr.toString().replace( "/", "" );
vr = vr.toString().replace( ",", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
tam = vr.length;

if (tam < tammax && tecla != 8){ tam = vr.length + 1; }

if (tecla == 8 ){ tam = tam - 1; }

if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
if ( tam <= 2 ){
document.getElementById(id).value = vr; }
if ( (tam > 2) && (tam <= 5) ){
document.getElementById(id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 6) && (tam <= 8) ){
document.getElementById(id).value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 9) && (tam <= 11) ){
document.getElementById(id).value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 12) && (tam <= 14) ){
document.getElementById(id).value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 15) && (tam <= 17) ){
document.getElementById(id).value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );}
}
}
</script>
<script language='javascript'>
function confirmaExclusao(aURL) {
if(confirm('Você tem certeza que deseja excluir?')) {
location.href = aURL;
}
}
</script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1036" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF0000">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="973" background="../imagens/message_toolbar_tile.gif"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="915"><strong>Server 5 - 2.0</strong> | Desenvolvido por Alexandre Sousa | E-mail: alexandre@uniaomaker.com.br</td>
            <td width="49" align="right" valign="middle"><a href="sair.php"><img src="../imagens/finaliza.jpg" width="16" height="16" border="0" align="absmiddle" id="sprytrigger20" /></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tabela_exemplo">
          <tr>
            <td><ul id="MenuBar1" class="MenuBarHorizontal">
              <li><a href="index.php"><strong><img src="../imagens/agt_home.png" width="22" height="22" border="0" align="absmiddle" /></strong> Inicio</a></li>
              <li><a href="#" class="MenuBarItemSubmenu"><strong><img src="../imagens/filenew2.png" width="22" height="22" border="0" align="absmiddle" /> </strong>Cadastros</a>
                  <ul>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/agt_forum.png" width="22" height="22" border="0" align="absmiddle" /> Usu&aacute;rios</a>
                        <ul>
                          <li><a href="?pg=add_cliente"><img src="../imagens/filenew2.png" width="22" height="22" border="0" align="absmiddle" /> Cadastra</a></li>
                          <li><a href="?pg=list_client"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Lista</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/clientes.jpg" width="22" height="22" border="0" align="absmiddle" /> Login</a>
                        <ul>
                          <li><a href="?pg=ad_login"><img src="../imagens/filenew2.png" width="22" height="22" border="0" align="absmiddle" /> Cadastrar</a></li>
                          <li><a href="?pg=list_login"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Listar</a></li>
                          <li><a href="?pg=list_login_geral"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Lista Geral</a></li>
                          <li><a href="#"><img src="../img/zoom.png" width="16" height="16" border="0" align="absmiddle" /> Procura</a></li>
                          <li><a href="?pg=list_login_ip"><img src="../img/application-x-smb-workgroup.png" width="22" height="22" border="0" align="absmiddle" /> Lista Rapida</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/daemons.png" width="22" height="22" border="0" align="absmiddle" /> Planos</a>
                        <ul>
                          <li><a href="?pg=list_banda"><img src="../imagens/filter.png" width="22" height="22" border="0" align="absmiddle" /> Banda</a></li>
                          <li><a href="?pg=add_grupo_tempo"><img src="../imagens/kalarm.png" width="22" height="22" border="0" align="absmiddle" /> Agendamento</a></li>
                          <li><a href="?pg=add_volume"><img src="../imagens/file_broken.png" width="22" height="22" border="0" align="absmiddle" /> Volume</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/decrypted.png" width="22" height="22" border="0" align="absmiddle" />E-Sec</a>
                        <ul>
                          <li><a href="?pg=gerador"><img src="../imagens/package.png" width="22" height="22" border="0" align="absmiddle" /> Keigen + Cad</a></li>
                          <li><a href="?pg=list_esec"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Listar</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/agt_family.png" width="22" height="22" border="0" align="absmiddle" /> Login Admin</a>
                        <ul>
                          <li><a href="?pg=add_admin"><img src="../imagens/funcionarios.jpg" width="22" height="22" border="0" align="absmiddle" /> Cadastra</a></li>
                          <li><a href="?pg=list_admin"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Lista</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/funcionarios.jpg" width="22" height="22" border="0" align="absmiddle" /> Avisos</a>
                        <ul>
                          <li><a href="?pg=add_aviso"><img src="../imagens/kterm.png" width="22" height="22" border="0" align="absmiddle" /> Aviso en Tela</a></li>
                          <li><a href="?pg=list_aviso"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Lista Avisos</a></li>
                        </ul>
                    </li>
                  </ul>
              </li>
              <li><a href="#" class="MenuBarItemSubmenu"><strong><img src="../imagens/advancedsettings.png" width="22" height="22" border="0" align="absmiddle" /> </strong>Configurações</a>
                  <ul>
                    <li><a href="?pg=parametros"><img src="../imagens/ordem.jpg" width="22" height="22" border="0" align="absmiddle" /> Parametros</a></li>
                    <li><a href="?pg=desloga_conf"><img src="../imagens/agt_forum.png" width="22" height="22" border="0" align="absmiddle" /> Deslogar</a></li>
                    <li><a href="?pg=list_rede"><img src="../imagens/hardware.png" width="22" height="22" border="0" align="absmiddle" /> Rede</a></li>
                    <li><a href="#"><img src="../imagens/mini_squid.jpg" width="22" height="22" border="0" align="absmiddle" /> Proxy</a></li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/proxy.png" width="22" height="22" border="0" align="absmiddle" /> Squid</a>
                        <ul>
                          <li><a href="?pg=add_palavras"><img src="../imagens/exclamation02.gif" width="22" height="22" border="0" align="absmiddle" /> Proibidos</a></li>
                          <li><a href="?pg=add_liberados"><img src="../imagens/clientes.jpg" width="22" height="22" border="0" align="absmiddle" /> Libera Proibidos</a></li>
                          <li><a href="?pg=maxconn"><img src="../imagens/wifi.png" width="22" height="22" border="0" align="absmiddle" /> Conex&otilde;es</a></li>
                        </ul>
                    </li>
                  </ul>
              </li>
              <li><a href="#" class="MenuBarItemSubmenu"><strong><img src="../imagens/vcalendar.png" width="22" height="22" border="0" align="absmiddle" /></strong> Relatorios</a>
                  <ul>
                    <li><a href="?pg=logados"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Logados</a> </li>
                    <li><a href="?pg=h_livres"><img src="../imagens/wby01sla.gif" width="22" height="22" border="0" align="absmiddle" /> Hosts Livres</a></li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/file_broken.png" width="22" height="22" border="0" align="absmiddle" /> Graficos</a>
                      <ul>
                        <li><a href="?pg=busca_data"><img src="../imagens/kspread_ksp.png" width="22" height="22" border="0" align="absmiddle" /> Rel Geral</a></li>
                        <li><a href="?pg=busca_entre_data"><img src="../imagens/kexi_kexi.png" width="22" height="22" border="0" align="absmiddle" /> Entre Datas</a></li>
                      </ul>
                      </li>
                    <li><a href="?pg=logs"><img src="../imagens/vcalendar.png" width="22" height="22" border="0" align="absmiddle" /> Logs</a></li>
                  </ul>
              </li>
              <li><a href="#" class="MenuBarItemSubmenu"><strong><img src="../imagens/database.png" width="22" height="22" border="0" align="absmiddle" /> </strong>Financeiro</a>
                  <ul>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/money.png" width="22" height="22" border="0" align="absmiddle" /> A Receber</a>
                        <ul>
                          <li><a href="?pg=financeiro/add_pre_conta_receber"><img src="../imagens/add.gif" width="22" height="22" border="0" align="absmiddle" /> Adicionar</a></li>
                          <li><a href="?pg=financeiro/list_conta_a_receber"><img src="../imagens/txt.png" width="22" height="22" border="0" align="absmiddle" /> Baixar</a></li>
                          <li><a href="?pg=financeiro/list_contas_receber_vencidas"><img src="../imagens/edit.gif" width="22" height="22" border="0" align="absmiddle" /> Em Atraso</a></li>
                          <li><a href="?pg=financeiro/cancela_conta_a_receber"><img src="../imagens/button_cancel.png" width="22" height="22" border="0" align="absmiddle" /> Cancelar</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/money_delete.png" width="22" height="22" border="0" align="absmiddle" /> A Pagar</a>
                        <ul>
                          <li><a href="?pg=financeiro/add_conta_pagar"><img src="../imagens/add.gif" width="22" height="22" border="0" align="absmiddle" /> Adiciona</a></li>
                          <li><a href="?pg=financeiro/list_conta_pagar"><img src="../imagens/txt.png" width="22" height="22" border="0" align="absmiddle" /> Baixar</a></li>
                          <li><a href="?pg=financeiro/list_conta_paga_vencidas"><img src="../imagens/edit.gif" width="22" height="22" border="0" align="absmiddle" /> Em Atraso</a></li>
                          <li><a href="?pg=financeiro/list_cancela_conta_paga"><img src="../imagens/button_cancel.png" width="22" height="22" border="0" align="absmiddle" /> Cancelar</a></li>
                        </ul>
                    </li>
                    <li><a href="?pg=financeiro/add_planos"><img src="../imagens/file_broken.png" width="22" height="22" border="0" align="absmiddle" /> Planos</a></li>
                    <li><a href="?pg=financeiro/edit_aviso&amp;id=1"><img src="../imagens/exclamation02.gif" width="22" height="22" border="0" align="absmiddle" /> Aviso</a></li>
                  </ul>
              </li>
              <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/package.png" width="22" height="22" border="0" align="absmiddle" /> Inventario</a>
                  <ul>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/clientes.jpg" width="22" height="22" border="0" align="absmiddle" /> Cliente</a>
                        <ul>
                          <li><a href="?pg=add_inventario"><img src="../imagens/add.gif" alt="" width="22" height="22" border="0" align="absmiddle" /> Adicionar</a></li>
                          <li><a href="?pg=list_inventario"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Listar</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/remote.png" width="22" height="22" border="0" align="absmiddle" /> Provedor</a>
                        <ul>
                          <li><a href="?pg=add_i_provedor"><img src="../imagens/add.gif" width="22" height="22" border="0" align="absmiddle" /> Adicionar</a></li>
                          <li><a href="?pg=list_i_provedor"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Listar</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="MenuBarItemSubmenu"><img src="../imagens/Gnome-Network-Wireless-64.png" width="22" height="22" border="0" align="absmiddle" /> Radios/PTP</a>
                        <ul>
                          <li><a href="?pg=add_radio"><img src="../imagens/add.gif" width="22" height="22" border="0" align="absmiddle" /> Adicionar</a></li>
                          <li><a href="?pg=list_radio"><img src="../imagens/lassists.png" width="22" height="22" border="0" align="absmiddle" /> Listar</a></li>
                        </ul>
                    </li>
                  </ul>
              </li>
              <li><a href="?pg=../os/inicio&amp;os=1"><img src="../imagens/funcionarios.jpg" width="22" height="22" border="0" align="absmiddle" /> Suporte</a></li>
            </ul></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
		<?php

$os = $_GET[os];

if (1 == $os){

include "../os/index.php";
}
else 
{}

?>
		
		<?php include "query.php"; ?></td>
      </tr>
      <tr>
        <td background="../imagens/message_toolbar_tile.gif"><table width="100%" border="0">
            <tr>
              <td width="21"><a href="index.php"><strong><img src="../imagens/pinguim.jpg" width="20" height="20" border="0" align="absmiddle" /></strong></a></td>
              <td width="703"><div align="center"></div></td>
              <td width="242"><img src="../imagens/uniaomaker.png" width="80" height="15" /><img src="../imagens/css.gif" width="80" height="15" /><img src="../imagens/xhtml.gif" width="80" height="15" /></td>
            </tr>
          </table></td>
      </tr>

    </table></td>
  </tr>
</table>

<div class="imputTxt" id="sprytooltip20"><img src="../imagens/atraso.png" width="22" height="22" border="0" align="absmiddle" /> Encerrar Sessão</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
var sprytooltip20 = new Spry.Widget.Tooltip("sprytooltip20", "#sprytrigger20");
//-->
</script>
</body>
</html>
