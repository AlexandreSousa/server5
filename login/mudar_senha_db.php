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


$usuario = $_POST[usuario];
$senha_atual = $_POST[senha_atual];
$nova_senha = $_POST[nova_senha];
$repita_senha = $_POST[repita_senha];

$colname_qr_ser = "-1";
if (isset($_GET['login'])) {
  $colname_qr_ser = $_GET['login'];
}
mysql_select_db($database_Conexao, $Conexao);
$query_qr_ser = sprintf("SELECT * FROM usuarios WHERE login = '$usuario'", GetSQLValueString($colname_qr_ser, "text"));
$qr_ser = mysql_query($query_qr_ser, $Conexao) or die(mysql_error());
$row_qr_ser = mysql_fetch_assoc($qr_ser);
$totalRows_qr_ser = mysql_num_rows($qr_ser);

$idf = $row_qr_ser['id'];
$senha_atual_db = $row_qr_ser['senha'];

$idf;

if ($senha_atual == $senha_atual_db){

	if($nova_senha == $repita_senha){
	echo "Senha Auterada Con sucesso";
	$sql = "UPDATE usuarios SET senha='$nova_senha' WHERE id='$idf'";
    $resultado = mysql_query($sql) or die(mysql_error());
	}
	else 
	{
	echo "A NOVA SENHA NÃO CONFERE TENTE NOVAMENTE";
	}



}
else 
{
echo "SENHA ATUAL NÃO CONFERE";
} 

//$sql = "UPDATE cliente SET id='$id_novo',nome='$nome_novo', cpf='$nome2_novo',data_nas='$data_nas_novo',cod_card='$cod_card_novo' WHERE id='$id_novo'";
//$resultado = mysql_query($sql) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_ser);
?>
