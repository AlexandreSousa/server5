<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//pega dia do vencimento
$venc = $row_nome['vencimento'];

// leitura das datas
$dia = date('d');
$mes = date('m');
$ano = date('Y');
$semana = date('w');


// configuração mes

switch ($mes){

case 1: $mes = "01"; break;
case 2: $mes = "02"; break;
case 3: $mes = "03"; break;
case 4: $mes = "04"; break;
case 5: $mes = "05"; break;
case 6: $mes = "06"; break;
case 7: $mes = "07"; break;
case 8: $mes = "08"; break;
case 9: $mes = "09"; break;
case 10: $mes = "10"; break;
case 11: $mes = "11"; break;
case 12: $mes = "12"; break;

}


// configuração semana

switch ($semana) {

case 0: $semana = "Domingo"; break;
case 1: $semana = "Segunda-Feira"; break;
case 2: $semana = "Terça-Feira"; break;
case 3: $semana = "Quarta-Feira"; break;
case 4: $semana = "Quinta-Feira"; break;
case 5: $semana = "Sexta-Feira"; break;
case 6: $semana = "Sábado"; break;

}
// pegar dia vencimento


function get_nextDay($day, $ts=null)
{
    if (is_null($ts)) {
        $ts = time();
    }
    $month = date('m', $ts);
    $year  = date('Y', $ts);
    $wanted_ts = mktime(0,0,0, $month, $day, $year);
    if ($wanted_ts < $ts) {
        $wanted_ts = strtotime('+1 month', $wanted_ts);
    }
    return $wanted_ts;

}

// Captura a data de hoje
$timestamp = get_nextDay (12);

// imprime o dia proximo vencimento
$vencimento = date('Y-m-d', $timestamp);
?>

<?php
$documento = $_POST['n_documento'];
$cliente = $_POST['cliente'];
$tipo_documento = $_POST['tipo_documento'];
$emissao = $_POST['emissao'];
$obs = $_POST['obs'];
$n_parcela = $_POST['n_parcela'];
$parcela = 1;
$venc_data = $_POST['vencimento'];
$d = $_POST['vencimento'];
$d = explode('-', $d);
$d = $d[2]."-".$d[1]."-".$d[0];
$valor = $_POST['valor'];
$valor = explode(',', $valor);
$valor = $valor[0].".".$valor[1];
$valor = $valor+0;
str_replace(",",".",str_replace(".","",$valor));

?>
<?php $documento = rand(1,5000); ?>

<?php $hora = date("H:i"); ?>