<?php

logadd("IN:($ip)$url");


if(preg_match("/^http:\/\/i[1-9]\.ytimg\.com\/u\/.*watch_header\.jpg/", $url, $resultado)) {
$url = "http://www.thundercache.org/images/thunder.jpg"; // altere para a imagem que você desejar

}

print "$url\n";

logadd("OUT:$url");

?>
