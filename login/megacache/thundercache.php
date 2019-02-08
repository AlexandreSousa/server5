<?php
#REV1
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
<link href="thunder.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<font color="#0C70EE">Relatório do sistema Thunder cache : <br></font><br>
<table border="1" align="center">
 <tr class="cabecalho"><td>Domínio</td><td>Arquivos</td><td>Tamanho</td><td>Economia</td><td>Hits</td></tr>
<?
	foreach($domains as $domain){

		
		$hashdomain = lock_hash("$cache_dir/$domain/domain.inf");
		$domaininf = read_hash($hashdomain);
		$totalfiles += $domaininf[files];
		$totalsize += $domaininf[size];
		$totalhits += $domaininf[hits];
		$ecosize = ($domaininf[size]+$domaininf[sized]);
		$ecofiles = ($domaininf[files]+$domaininf[filesd]);            
                $totaleconomy += (($ecosize/$ecofiles)*($domaininf[hits]-$ecofiles));
?>
 <tr><td height="18"><font color="#20A253"><?= $domain ?></font></td>
	<td height="18"><font color="#20A253"><?= $domaininf[files] ?></font></td>
	<td height="18"><font color="#20A253"><?= round($domaininf[size]/1024/1024/1024,2)." Gb" ?></font></td>
	<td height="18"><font color="#20A253"><?= round((($ecosize/$ecofiles)*($domaininf[hits]-$ecofiles))/1024/1024/1024,2) ." Gb" ?></font></td>
	<td height="18"><font color="#20A253"><?= $domaininf[hits] ?></font></td></tr>
<?
		lock_hash("",$hashdomain);
	}
?>
  <tr><td height="22"><b><font color="#0C70EE">Total</font></b></td>
	<td height="22"><b><font color="#0C70EE"><?= $totalfiles ?></font></b></td>
	<td height="22"><b><font color="#0C70EE"><?= round($totalsize/1024/1024/1024,2)." Gb" ?></font></b></td>
	<td height="22"><b><font color="#0C70EE"><?= round($totaleconomy/1024/1024/1024,2) ." Gb" ?></font></b></td>
	<td height="22"><b><font color="#0C70EE"><?= $totalhits ?></font></b></td></tr>
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
