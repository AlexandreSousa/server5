<?php require_once('../Connections/Conexao.php'); ?>
<?php require_once('../config.php'); ?>

<?php

//Lista os clientes logados e pergunta para a sessao
$sql = mysql_query ("SELECT * FROM logados"); 
$linhas = mysql_num_rows($sql);

for($i=0;$i<$linhas;$i++){
        $logado  =  mysql_result($sql,$i,'id');
        $id  =  mysql_result($sql,$i,'id_cliente');
	$login  =  mysql_result($sql,$i,'login');
	$ip =  mysql_result($sql,$i,'ip');
	$up =  mysql_result($sql,$i,'up');
	$down =  mysql_result($sql,$i,'down');

$pdow= shell_exec("tail /var/www/server/banda/$ip-down");
$pup= shell_exec("cat /var/www/server/banda/$ip-up");   
 

$sql2 = "UPDATE sessao SET login='$login', ip='$ip',down='$pdow',up='$pup' WHERE id_logado='$logado'";
$resultado = mysql_query($sql2) or die(mysql_error());
      
$sql3 = "UPDATE logados SET down='$pdow',up='$pup' WHERE id_cliente='$id'";
$resultado = mysql_query($sql3) or die(mysql_error());  
}
	?>
