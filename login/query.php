<style >
body {
	
	  font-family: Verdana, Arial, Helvetica, sans-serif;
	  font-size: 12px;
	  color: #003366;
	
}
    </style>
    

<?
$var = "principal.php";
$pg = "$_GET[pg].php";
if(empty($_SERVER["QUERY_STRING"])) {
include($var);
} else {
include("$pg");
}
?>