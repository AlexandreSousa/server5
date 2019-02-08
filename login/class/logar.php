<?php
$dlog= date("Y-m-d");
$hlog_i= date("H:s");

$sql = "INSERT INTO logados (ip,id_cliente,proxy,mac,login,senha) VALUES ('$ip', '$id','$proxy','$mac', '$login', '$senha')";
$query = mysql_query($sql) or die("erro:".mysql_error());


$sql = mysql_query ("SELECT * FROM logados WHERE id_cliente = '$id'"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
    $logado  =  mysql_result($sql,$i,'id');
	$login  =  mysql_result($sql,$i,'login');
	$ip =  mysql_result($sql,$i,'ip');
	$up =  mysql_result($sql,$i,'up');
	$down =  mysql_result($sql,$i,'down');


$sql2 = "INSERT INTO sessao (id_logado,login,ip,down,up,data,data_f, hora_i, hora_f) VALUES ('$logado', '$login','$ip','$down', '$up', '$dlog','$data_f','$hlog_i','$hlog_f')";
$query2 = mysql_query($sql2) or die("erro:".mysql_error());
	
	}

?>