<?php require_once('Connections/Conexao.php'); ?>
<?php require_once('config.php'); ?>
<?php

// Pega o IP do Cliente
$ipcliente = $_SERVER['HTTP_X_FORWARDED_FOR'];

// Busca os dados do cliente no mysql
mysql_select_db($database_Conexao, $Conexao);
$query_RSMaclist = "SELECT mac, ip, login FROM usuarios WHERE ip = '$ipcliente'";
$RSMaclist = mysql_query($query_RSMaclist, $Conexao) or die(mysql_error());
$row_RSMaclist = mysql_fetch_assoc($RSMaclist);
$totalRows_RSMaclist = mysql_num_rows($RSMaclist);

// Armazena os dados em variáveis
$mac = $row_RSMaclist['mac'];
$ip = $row_RSMaclist['ip'];
$login = $row_RSMaclist['login'];

// Data e hora
$data = date("d.m.y");
$hora = date("H:i:s");

// Abre e grava no arquivo de log
$logfile = "/var/log/weblogin/weblogin.log";
$abrir = fopen($logfile, "a");

if ( $ip == $ipcliente )
	{

	// Regras pra travar MAC x IP
	shell_exec("/usr/bin/sudo /sbin/iptables -D FORWARD -d 0/0 -s $ip -m mac --mac-source $mac -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -D FORWARD -s 0/0 -d $ip -mstate --state ESTABLISHED,RELATED -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D POSTROUTING -s $ip -d 0/0 -j SNAT --to $servidor");

	// Regras Conectividade Social
	shell_exec("/usr/bin/sudo /sbin/iptables -D INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -D INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -D INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT");
	shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT");

	// Redireciona o trafego da porta 80 pra porta do proxy Squid
	shell_exec("/usr/bin/sudo /sbin/iptables -t nat -D PREROUTING -s $ip -m mac --mac-source $mac -p tcp --dport 80 -j REDIRECT --to-port $squid");

	// Cria cadeia de regras pra redirecionar o cliente novamente pro sistema de login
	shell_exec("/usr/bin/sudo /sbin/iptables  -t nat -N PRE-$ip");
	shell_exec("/usr/bin/sudo /sbin/iptables  -t nat -A PRE-$ip -p tcp -s $ip --dport 80 -j REDIRECT --to-port 82");
	shell_exec("/usr/bin/sudo /sbin/iptables  -t nat -A PREROUTING -p tcp -s $ip --dport 80 -j PRE-$ip");

	// Grava log
	$error_log = "CONEXAO FINALIZADA COM SUCESSO - $data - $hora - Usuario: $login IP: $ip MAC: $mac\r\n ";
	fwrite($abrir, $error_log);
	fclose($abrir);

	// Redireciona o cliente pra pagina de login
	header("Location:http://$servidor:82/index.php?url=$siteprovedor&logout=sim");

	}

// Se o IP que tentou desconectar nao estiver no banco de dados do SGCU ele é redirecionado pra página do provedor

if ( $ip <> $ipcliente )
	{

	header("Location:http://$siteprovedor");

	}

// Fecha a conexão com o banco de dados
mysql_free_result($RSMaclist);
?>