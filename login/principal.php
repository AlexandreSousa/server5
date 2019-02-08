<?php require_once('Connections/Conexao.php'); ?>
<?php
$user = $_SESSION['MM_Username']; 
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

$colname_qr_usuario = "-1";
if (isset($_GET['login'])) {
  $colname_qr_usuario = $_GET['login'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_usuario = sprintf("SELECT * FROM usuarios WHERE login = '$user'", GetSQLValueString($colname_qr_usuario, "text"));
$qr_usuario = mysql_query($query_qr_usuario, $Conexao) or die(mysql_error());
$row_qr_usuario = mysql_fetch_assoc($qr_usuario);
$totalRows_qr_usuario = mysql_num_rows($qr_usuario);
?><html>
  <head>
    <title></title>
    <meta content="">
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
  <table width="100%" border="0" align="center">
    <tr>
      <td><strong>Painel de Avisos</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="style1"><img src="imagens/atraso.png" width="22" height="22" border="0" align="absmiddle"> <?php echo $row_qr_usuario['msg']; ?></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
</html>
<?php
mysql_free_result($qr_usuario);
?>