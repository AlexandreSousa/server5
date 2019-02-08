<?php
/** 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Library General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
* (C) Copyright 2008-2009 Thunder Cache
*
* For more information check http://thundercache.org
*
* Streaming and get relatories from system
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

	error_reporting(0);
	$cache_scr = "/etc/squid";
	include ("$cache_scr/thunder.conf");
	include ("$cache_scr/functions.php");

	
	$file = $_GET["file"];
	$domain = $_GET["domain"];
	
	if (!empty($argv[1])){	
		$file = $argv[1];
		$domain = $argv[2];
	}
	
	if (empty($file)) {
		$domains = find_domains($cache_dir);
			?>
<HTML>
<HEAD>
</HEAD>
<BODY>
Relatorio do sistema Thunder cache v2.1: <br><br>
 <table border="1">
 <tr><td>Dominio</td><td>Arquivos</td><td>Tamanho</td><td>Economia</td><td>Hits</td></tr>
<?
	foreach($domains as $domain){
		$hashdomain = lock_hash("$cache_dir/$domain/domain.inf");
		$domaininf = read_hash($hashdomain);
		$totalfiles += $domaininf[files];
		$totalsize += $domaininf[size];
		$totaleconomy += (($domaininf[size]/$domaininf[files])*($domaininf[hits]-$domaininf[files]));
		$totalhits += $domaininf[hits];
?>
 <tr><td><?= $domain ?></td><td><?= $domaininf[files] ?></td><td><?= round($domaininf[size]/1024/1024/1024,2)." Gb" ?></td><td><?= round((($domaininf[size]/$domaininf[files])*($domaininf[hits]-$domaininf[files]))/1024/1024/1024,2) ." Gb" ?></td><td><?= $domaininf[hits] ?></td></tr>
<?
		lock_hash("",$hashdomain);
	}
?>
  <tr><td>Total</td><td><?= $totalfiles ?></td><td><?= round($totalsize/1024/1024/1024,2)." Gb" ?></td><td><?= round($totaleconomy/1024/1024/1024,2) ." Gb" ?></td><td><?= $totalhits ?></td></tr>
 </table>
</BODY>
</HTML>			
			
<?
	} else {

	header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Pragma: no-cache");
	header("Content-Type: application/octet-stream");
	
	// wait for file exists
	logadd("Waiting for file: $file");
	while (!file_exists("$cache_dir/$domain/$file")) {
		usleep(250000);
	}
	logadd("File OK: $file");
	
	logadd("Waiting for reg: $file");
	while ($size == 0) {
		$hash = lock_hash("$cache_dir/$domain/inf/$file");
		$fileinf = read_hash($hash);
		$size = $fileinf[size];
		usleep(250000);
	}
	logadd("Reg OK: $file");
	
	//config headers
	session_cache_limiter('nocache');
	header("Content-Disposition: attachment; filename=\"" . $file. "\"");
	header("Content-Length: $size");
	// send file
	$f = fopen("$cache_dir/$domain/$file",'r');
	$total = 0;
	$last_mark = microtime(true);
	while ($total < $size) {
		usleep($packet_delay);
		
		if ((($total+$packet_size) >= $downloaded) and ($size != $downloaded)) {
			// if buffer overflow
			$tbuffer = ($downloaded-$total)-2;
		} else $tbuffer = $packet_size;
		
		if ($tbuffer > 0) {
			$buffer = fread($f, $tbuffer);
			print $buffer;
			set_time_limit(1);
			$total += strlen($buffer);
		}

		
		if (($size != $downloaded) and (intval(microtime(true)-$last_mark) > 1)) {
			$ultimo_tempo = microtime(true);
			$fileinf = read_hash($hash);
			$downloaded = $fileinf[downloaded];
		}

	}

	fclose($f);
	lock_hash("",$hash);
	}
?>
