<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>

<?php
$sql = mysql_query ("SELECT * FROM logados"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
	$ip =  mysql_result($sql,$i,'ip');
	$mac =  mysql_result($sql,$i,'mac');
	$proxy =  mysql_result($sql,$i,'proxy');
	
	//Autenticar quem ja tiver logado
	   shell_exec("sudo iptables -nvxL control |grep $ip | tail -2 | awk ' {print $2}' > /var/www/server/banda/$ip-bandwidthCurrent 2>&1 1> /dev/null");
	
	}
	?>