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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO os_servico (solicitante, solicitado, problema, data_abertura, hora_aberta, data_fechamento, hora_fecha, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['solicitante'], "text"),
                       GetSQLValueString($_POST['solicitado'], "text"),
                       GetSQLValueString($_POST['problema'], "text"),
                       GetSQLValueString($_POST['data_abertura'], "date"),
                       GetSQLValueString($_POST['hora_aberta'], "date"),
                       GetSQLValueString($_POST['data_fechamento'], "date"),
                       GetSQLValueString($_POST['hora_fecha'], "date"),
                       GetSQLValueString($_POST['estatus'], "text"));

  mysql_select_db($database_Conexao, $Conexao);
  $Result1 = mysql_query($insertSQL, $Conexao) or die(mysql_error());
  echo "<meta http-equiv='refresh' content='0;URL=index.php?pg=../os/list_os_abertas&os=1'>";
}

mysql_select_db($database_Conexao, $Conexao);
$query_qr_open_os = "SELECT * FROM os_servico";
$qr_open_os = mysql_query($query_qr_open_os, $Conexao) or die(mysql_error());
$row_qr_open_os = mysql_fetch_assoc($qr_open_os);
$totalRows_qr_open_os = mysql_num_rows($qr_open_os);

mysql_select_db($database_Conexao, $Conexao);
$query_qr_users = "SELECT * FROM usuarios";
$qr_users = mysql_query($query_qr_users, $Conexao) or die(mysql_error());
$row_qr_users = mysql_fetch_assoc($qr_users);
$totalRows_qr_users = mysql_num_rows($qr_users);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/tabelas.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="35%" align="right" nowrap="nowrap">Solicitante:</td>
      <td width="65%"><input type="hidden" name="solicitante" value="<?php echo $_SESSION['MM_Username']; ?>" size="32" />
      <?php echo $_SESSION['MM_Username']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Solicitado:</td>
      <td><label>
        <select name="solicitado" class="imputTxt" id="solicitado">
          <?php
do {  
?>
          <option value="<?php echo $row_qr_users['login']?>"><?php echo $row_qr_users['login']?></option>
          <?php
} while ($row_qr_users = mysql_fetch_assoc($qr_users));
  $rows = mysql_num_rows($qr_users);
  if($rows > 0) {
      mysql_data_seek($qr_users, 0);
	  $row_qr_users = mysql_fetch_assoc($qr_users);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><p></p>
      </td>
      <td>  <script type="text/javascript">
  $(document).ready(function(){
  $("#endereco").click(function(evento){
  		if ($("#endereco").attr("checked")){
			$(".alvo").css("display", "block");
		}else{
				$(".alvo").css("display", "none");
			}
		});
	});
	
</script>
 <label><input type="checkbox" name="endereco" id="endereco" value="1" />teste</label>

</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap"><div style="display: none; margin-top:12px" class="alvo">
  
  Endereço
  
  </div></td>
      <td> <div style="display: none; margin-top:12px" class="alvo">
  
  <input name="endereco" type="text"  id="text"/>
  
  </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Problema:</td>
      <td><label>
        <textarea name="problema" cols="20" rows="5" class="imputTxt" id="problema"></textarea>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Data Abertura:</td>
      <td><input name="data_abertura" type="text" class="imputTxt" value="<?php echo ("$ano-$mes-$dia"); ?>" size="10" />
      <input type="hidden" name="data_fechamento" value="" size="32" />
      <input type="hidden" name="hora_fecha" value="" size="32" />
      <input type="hidden" name="estatus" value="aberto" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hora Aberta:</td>
      <td><input name="hora_aberta" type="text" class="imputTxt" value="<?php echo $hora; ?>" size="10" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="BnT" id="form1" value="Abrir OS" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($qr_open_os);

mysql_free_result($qr_users);
?>
