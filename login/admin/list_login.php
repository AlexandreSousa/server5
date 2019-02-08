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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_lo_list = 10;
$pageNum_lo_list = 0;
if (isset($_GET['pageNum_lo_list'])) {
  $pageNum_lo_list = $_GET['pageNum_lo_list'];
}
$startRow_lo_list = $pageNum_lo_list * $maxRows_lo_list;

mysql_select_db($database_Conexao, $Conexao);
$query_lo_list = "SELECT * FROM usuarios";
$query_limit_lo_list = sprintf("%s LIMIT %d, %d", $query_lo_list, $startRow_lo_list, $maxRows_lo_list);
$lo_list = mysql_query($query_limit_lo_list, $Conexao) or die(mysql_error());
$row_lo_list = mysql_fetch_assoc($lo_list);

if (isset($_GET['totalRows_lo_list'])) {
  $totalRows_lo_list = $_GET['totalRows_lo_list'];
} else {
  $all_lo_list = mysql_query($query_lo_list);
  $totalRows_lo_list = mysql_num_rows($all_lo_list);
}
$totalPages_lo_list = ceil($totalRows_lo_list/$maxRows_lo_list)-1;

mysql_select_db($database_Conexao, $Conexao);
$query_qr_logados = "SELECT * FROM logados";
$qr_logados = mysql_query($query_qr_logados, $Conexao) or die(mysql_error());
$row_qr_logados = mysql_fetch_assoc($qr_logados);
$totalRows_qr_logados = mysql_num_rows($qr_logados);



$queryString_lo_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lo_list") == false && 
        stristr($param, "totalRows_lo_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lo_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lo_list = sprintf("&totalRows_lo_list=%d%s", $totalRows_lo_list, $queryString_lo_list);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	color: #FF0000;
	font-weight: bold;
}
.style5 {font-weight: bold; font-size: 12px;}
-->
</style></head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <th colspan="5" bgcolor="#FF9900">Listagen de Logins</th>
  </tr>
  <tr>
    <th width="12%" background="../imagens/message_toolbar_tile.gif">ID</th>
    <th width="20%" background="../imagens/message_toolbar_tile.gif">Login</th>
    <th width="23%" background="../imagens/message_toolbar_tile.gif">Senha</th>
    <th width="25%" background="../imagens/message_toolbar_tile.gif">Informações</th>
    <th width="20%" background="../imagens/message_toolbar_tile.gif">Açoes</th>
  </tr>
  <?php do { ?>
    <tr>
      <td valign="top"><?php echo $row_lo_list['id']; ?></td>
      <td align="center" valign="top"><?php echo $row_lo_list['login']; ?></td>
      <td align="center" valign="top"><?php echo $row_lo_list['senha']; ?></td>
      <td><table width="100%" border="0">
        <tr>
          <td width="182" bgcolor="#CCCC66"><span class="style5">Ip:</span><span class="style1"> <?php echo $row_lo_list['ip']; ?></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCCC66"><span class="style5">Mac:</span><span class="style1"> <?php echo $row_lo_list['mac']; ?></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCCC66"><span class="style5">Proxy:</span><span class="style1"> <?php echo $row_lo_list['proxy']; ?></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCCC66"><span class="style5">Banda:</span><span class="style1"><?php 
		$teste = $row_lo_list['banda']; 

$colname_Recordset1qr_banda = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1qr_banda = $_GET['id'];
 
}
mysql_select_db($database_Conexao, $Conexao);
$query_Recordset1qr_banda = sprintf("SELECT * FROM banda WHERE id =  '$teste'", GetSQLValueString($colname_Recordset1qr_banda, "int"));
$Recordset1qr_banda = mysql_query($query_Recordset1qr_banda, $Conexao) or die(mysql_error());
$row_Recordset1qr_banda = mysql_fetch_assoc($Recordset1qr_banda);
$totalRows_Recordset1qr_banda = mysql_num_rows($Recordset1qr_banda);
		  
		 echo $row_Recordset1qr_banda['desc'];
		  
		  ?> </span></td>
        </tr>
        <tr>
          <td bgcolor="#CCCC66">
		  <?php 
		
		    $login = $row_lo_list['login'];
			$sql = mysql_query("SELECT * FROM logados WHERE login='$login '");
			$total = mysql_num_rows($sql);
			if($total > 0){
			echo "<font color='green'><strong><img src='../imagens/agt_action_success.png' />Logado</strong></font></a>";
			} else {
			echo "<font color='red'><img src='../imagens/button_cancel.png' /><strong>Deslogado</strong></font>";
			}
			?>
		  </td>
        </tr>
      </table></td>
      <td align="center" valign="top"><table width="149" border="0">
        <tr>
          <td width="143" align="center"><a href="?pg=edit_login&id=<?php echo $row_lo_list['id']; ?>"><img src="../imagens/botao_edit.png" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td align="center"><a href="?pg=del_login&id=<?php echo $row_lo_list['id']; ?>"><img src="../imagens/botao_drop.png" width="16" height="16" border="0" /></a></td>
        </tr>
      </table></td>
    </tr>
    <?php } while ($row_lo_list = mysql_fetch_assoc($lo_list)); ?>
  <tr>
    <td height="45" colspan="5" align="center"><table border="0">
        <tr>
          <td><?php if ($pageNum_lo_list > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_lo_list=%d%s", $currentPage, 0, $queryString_lo_list); ?>">First</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_lo_list > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_lo_list=%d%s", $currentPage, max(0, $pageNum_lo_list - 1), $queryString_lo_list); ?>">Previous</a>
                <?php } // Show if not first page ?>
          </td>
          <td><?php if ($pageNum_lo_list < $totalPages_lo_list) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_lo_list=%d%s", $currentPage, min($totalPages_lo_list, $pageNum_lo_list + 1), $queryString_lo_list); ?>">Next</a>
                <?php } // Show if not last page ?>
          </td>
          <td><?php if ($pageNum_lo_list < $totalPages_lo_list) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_lo_list=%d%s", $currentPage, $totalPages_lo_list, $queryString_lo_list); ?>">Last</a>
                <?php } // Show if not last page ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($lo_list);

mysql_free_result($Recordset1qr_banda);

mysql_free_result($qr_logados);
?>
