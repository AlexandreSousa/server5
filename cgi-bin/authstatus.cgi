#!/bin/bash
echo "Content-type:text/html"
echo

cat /var/log/weblogin/weblogin.log > /tmp/log.tmp

echo "<html>"
echo "<head>"
echo "<title>Monitorar Autenticacao</title>"
echo "<meta http-equiv="refresh" content="5" />"
echo "</head>"
echo "<body>"
echo "<font="arial">"
echo "<fontsize="12">"
echo "<b>"
echo "Log de Autenticacao de Usuarios - Visualizacao das 30 ultimas conexoes"
echo "</b>"
echo "</font>"
echo "<pre>"
echo "<fontsize="9">"
tail -n 30 /tmp/log.tmp
echo "</font>"
echo "</pre>"
echo "</font>"
echo "</body>"
echo "</html>"

rm -f /tmp/log.tmp