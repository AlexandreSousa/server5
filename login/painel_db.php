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

echo $idf = $row_qr_usuario['id'];


$proxy = $_POST[proxy];
$site = $_POST[site];
$banda = $_POST[banda];


if ($proxy == ""){

}
else {
$sql = "INSERT INTO pedidos (usuario,aviso,situacao) VALUES ('$user','$proxy','aberto')";
$query = mysql_query($sql)  or die("erro:".mysql_error());
}

if($site == ""){

}
else{
$sql = "UPDATE usuarios SET site='$site' WHERE id='$idf'";
$resultado = mysql_query($sql) or die(mysql_error());
}
if ($banda == ""){
}
else{
$sql = "INSERT INTO pedidos (usuario,aviso,situacao) VALUES ('$user','$banda','aberto')";
$query = mysql_query($sql)  or die("erro:".mysql_error());
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($qr_usuario);
?>