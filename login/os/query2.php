<?php
var2 = Abrir+OS 


?>

<style >
body {
	
	  font-family: Verdana, Arial, Helvetica, sans-serif;
	  font-size: 12px;
	  color: #003366;
	
}
    </style>
<?
$var2 = "principal2.php";
$pg2 = "$_GET[pg2].php";
if(empty($_SERVER["QUERY_STRING"])) {
include($var2);
} else {
include("$pg2");
}
?>