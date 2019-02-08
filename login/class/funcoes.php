<?php
function colores( $str, $g )
{
    $str = strrev( $str );
    $cores = array( "#00AA00", "#FF6600", "#333399", "#1FDE1A", "#2F9CD9", "#300FDD", "#F6B43A", "#8E2D71", "#9C500E", "#936712", "#F58CAB", "#4D500E", "#1D3EB5", "#20A78F", "#4C961A" );
    $seg = array( );
    $p = 0;
    for ( ; $p < strlen( $str ); $p += $g )
    {
        $seg[] = strrev( substr( $str, $p, $g ) );
    }
    $i = -1;
    $r = "";
    foreach ( $seg as $c )
    {
        ++$i;
        $dif = $i % $g;
        if ( $i <= 15 )
        {
            $cor = $cores[$i];
        }
        else
        {
            $cor = $cores[$dif];
        }
        $r = "<font color='{$cor}'>&nbsp;<b>{$c}</b></font>".$r;
    }
    return $r;
} 

function caminho ($var)
{

}
?>