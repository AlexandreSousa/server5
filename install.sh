echo "BEM VINDO AO INSTALADOR DO SERVER5"

echo -n "Deseja proseguir na instala��o? (s/n): "
read resposta
if [ "$resposta" = "S" -o "$resposta" = "s" ]; then


echo "instalando componentes"
sleep 2
#apt-get update
echo "se os pacotes solicitarem autoriza��o responda sim Y"
sleep 2
apt-get install shaper squid php5-cli


echo "www-data ALL=NOPASSWD: ALL" >> /etc/sudoers
echo "Configurando o sistema"
sleep 2
#cp /var/www/server/confs/squid /etc/init.d/
cp /var/www/server/confs/trafego /etc/cron.d/
cp /var/www/server/confs/scan /etc/cron.d/

rm /etc/rc.local
cp /var/www/server/confs/rc.local /etc/

rm /etc/squid/squid.conf
cp /var/www/server/confs/squid.conf /etc/squid/
rm /etc/apache2/sites-enabled/000-default
cp /var/www/server/confs/000-default /etc/apache2/sites-enabled
rm /etc/apache2/ports.conf
cp /var/www/server/confs/ports.conf /etc/apache2/
rm /etc/init.d/shaper
cp /var/www/server/confs/shaper /etc/init.d/shaper

/etc/init.d/apache2 restart
/etc/init.d/squid restart
/var/www/server/bin/firewall.sh

echo "SISTEMA INSTALADO E ALTAMENTE RECOMENDADO QUE REINICIE O SISTEMA PARA UM PERFEITO FUNCIONAMENTO"
echo "Se precisar de suporte entre em contato"
echo "Fone: (93) 8405-9966"
echo "MSN: sousa.akira@gmail.com"
sleep 10

    fi 
 
