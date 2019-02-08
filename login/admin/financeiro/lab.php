<?php

$valor = $_POST['valor'];
$contra = $_POST['contra'];

$val01 = number_format($valor, 2, "","");
echo $val01;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
// JavaScript Document



function FormataValor(id,tammax,teclapres) {

    

        if(window.event) { // Internet Explorer

         var tecla = teclapres.keyCode; }

        else if(teclapres.which) { // Nestcape / firefox

         var tecla = teclapres.which;

        }

    



vr = document.getElementById(id).value;

vr = vr.toString().replace( "/", "" );

vr = vr.toString().replace( "/", "" );

vr = vr.toString().replace( ",", "" );

vr = vr.toString().replace( ".", "" );

vr = vr.toString().replace( ".", "" );

vr = vr.toString().replace( ".", "" );

vr = vr.toString().replace( ".", "" );

tam = vr.length;



if (tam < tammax && tecla != 8){ tam = vr.length + 1; }



if (tecla == 8 ){ tam = tam - 1; }



if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){

if ( tam <= 2 ){

document.getElementById(id).value = vr; }

if ( (tam > 2) && (tam <= 5) ){

document.getElementById(id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ); }

if ( (tam >= 6) && (tam <= 8) ){

document.getElementById(id).value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }

if ( (tam >= 9) && (tam <= 11) ){

document.getElementById(id).value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }

if ( (tam >= 12) && (tam <= 14) ){

document.getElementById(id).value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }

if ( (tam >= 15) && (tam <= 17) ){

document.getElementById(id).value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );}

}

}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label>
  <input name="valor" type="text" class="imputTxt" id="valor" onkeypress="FormataValor(this.id, 10, event)" value="" size="17" />
  </label>
  <label>
  <input type="submit" name="teste2" id="teste2" value="Submit" />
  </label>
</form>
</body>
</html>
