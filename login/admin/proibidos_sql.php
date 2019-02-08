<?php require_once('../Connections/Conexao.php'); ?>
<?php

// limpando o arquivo
//echo shell_exec(" echo > ../clientes/ips.ss");
shell_exec("sudo rm -rf /var/www/server/squid/proibidos");
shell_exec ("touch sudo /var/www/server/squid/proibidos");

// executando a busca
$sql  = 'SELECT * FROM palavresproibidas';
$res = mysql_query($sql);

// se ocorreu algum erro
if (!$res) exit("Erro: ".mysql_error()." - ".$sql);


// dando um loop no resultado e escrevendo no arquivo
$i = 0;
while ($linha = mysql_fetch_array($res)) {


	// incrementando $i
	$i++;

	// limpando a linha
	$ins = "";


	$ins .= $linha["palavra"];
	
    $ins. "<br />";

	if ($ins) shell_exec("sudo echo $ins >> /var/www/server/squid/proibidos");

shell_exec("sudo /etc/init.d/squid reload");

}
?>