<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Conexao = "127.0.0.1";
$database_Conexao = "server5";
$username_Conexao = "root";
$password_Conexao = "455ttte";
$Conexao = mysql_pconnect($hostname_Conexao, $username_Conexao, $password_Conexao) or trigger_error(mysql_error(),E_USER_ERROR); 
$res = mysql_select_db($database_Conexao,$Conexao) or die ("erro ao selecionar a o banco de dados");
?>