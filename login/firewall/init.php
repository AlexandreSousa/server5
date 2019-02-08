<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>
<?php
//Iniciando o firewall

//Compartilhando a internet
shell_exec("sudo modprobe iptable_nat 2>&1 1> /dev/null");
shell_exec("sudo iptables -t nat -A POSTROUTING -o $ifnet -j MASQUERADE 2>&1 1> /dev/null"); 
shell_exec("sudo echo 1 > /proc/sys/net/ipv4/ip_forward");

//Redirecionando todo o trafego para a porta 82
shell_exec("iptables -t nat -A PREROUTING -s $ip_route/24 -p tcp --dport 80 -j DNAT --to $servidor:82 2>&1 1> /dev/null");


//Criando redirecionemento para as placas virtuais

?>

<?php
//$sql = mysql_query ("SELECT * FROM logados"); 
//$linhas = mysql_num_rows($sql);

//for($i=0;$i<$linhas;$i++){
//	$id_cliente =  mysql_result($sql,$i,'id_cliente');
//	$ip =  mysql_result($sql,$i,'ip');
//	$mac =  mysql_result($sql,$i,'mac');
//	$proxy =  mysql_result($sql,$i,'proxy');
	
	//Matando que tiver autenticado
	
	$sql = "DELETE FROM logados";
	$resultado = mysql_query($sql) or die (mysql_error());

	 // shell_exec("sudo iptables -t nat -A POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
	 //  shell_exec("sudo iptables -A FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");
	 //  shell_exec("sudo iptables -t nat -I PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
	 //  shell_exec("sudo iptables -A control -d $ip 2>&1 1> /dev/null");
	 //  shell_exec("sudo iptables -A control -s $ip 2>&1 1> /dev/null");
	   
	
	
	   //    if ( $proxy == sim )
           // { 
	    // Redireciona o trafego da porta 80 pra porta do proxy Squid
//	    shell_exec("/usr/bin/sudo /sbin/iptables -t nat -I PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid");
//}
	
//	}
	?>
