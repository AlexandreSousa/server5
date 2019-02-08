<?php
include ('../Connections/Conexao.php');
$sql = ("SELECT * FROM f_aviso");
$query = mysql_query($sql, $Conexao);
while($resultado = mysql_fetch_array($query)){
echo $id_cat = $resultado['aviso'];
}
?>