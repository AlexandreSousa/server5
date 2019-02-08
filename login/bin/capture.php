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
	 //  shell_exec("sudo cp -f /var/www/server/banda/$ip-bandwidthCurrent /var/www/server/banda/$ip-bandwidthOld");
	   shell_exec("sudo iptables -nvxL control |grep $ip | tail -2 | awk ' {print $2}' > /var/www/server/banda/$ip-bandwidthCurrent");
	   //Escrevendo arquivos separados com o trafego do usuario (o mesmo e apagado apos terminar a seção)
	$downCurrent = shell_exec("cat /var/www/server/banda/$ip-bandwidthCurrent | head -1 > /var/www/server/banda/$ip-down");
    $upCurrent = shell_exec("cat /var/www/server/banda/$ip-bandwidthCurrent | tail -1 > /var/www/server/banda/$ip-up");
	}
	?>