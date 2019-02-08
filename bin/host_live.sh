#!/bin/bash
sudo iptables -t nat -A POSTROUTING -s 192.168.25.5 -j MASQUERADE
sudo iptables -A FORWARD -s 192.168.25.5 -j ACCEPT
sudo iptables -t nat -I PREROUTING -s 192.168.25.5 -j ACCEPT
