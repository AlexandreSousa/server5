<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>

<?php
$sql = mysql_query ("SELECT * FROM v_lan"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
	$id =  mysql_result($sql,$i,'id');
	$id_eth =  mysql_result($sql,$i,'id_eth');
	$v_lan_ip =  mysql_result($sql,$i,'v_lan_ip');
	$mask =  mysql_result($sql,$i,'mask');
	
	//Liga as redes v_lan
	 shell_exec("sudo ifconfig $id_eth:$id $v_lan_ip/$mask 2>&1 1> /dev/null");
	
	}
	?>
