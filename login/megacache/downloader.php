#!/usr/bin/php
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
* Downloader script
* Use to download files
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

	error_reporting(0);
	umask(0);
	include ("functions.php");
	include ("thunder.conf");

	function update_db($last_downloaded=false){
		global $total,$cache_dir,$domain,$hash,$fileinf;
		if (!$last_downloaded) {
			$fileinf[downloaded] = $total;
			write_hash($hash,$fileinf);
		} else {
			$fileinf[downloaded] = $total;
			$fileinf[last_downloaded] = date("Y-m-d H:i:s");
			write_hash($hash,$fileinf);
		}
	}

	// check parms
	$url = $argv[1];
	$domain = $argv[2];
	$file = $argv[3];
	$streaming = $argv[4];
	if (empty($streaming)) $streaming = true;

	if (empty($url) || empty($file) || empty($domain)){
		print "Check parms\n";
		logadd("dw:Check parms");
		exit(1);
	} else {
		
		echo "downloading $file\n";
		logadd("downloading $file");

		$hash = lock_hash("$cache_dir/$domain/inf/$file");
		$fileinf = read_hash($hash);
		$exit = false;
		while(!$exit) {
			if (!file_exists("$cache_dir/$domain/$file")) {
				touch("$cache_dir/$domain/$file"); // create file
				chmod("$cache_dir/$domain/$file",0666);// change permissions
				$total = 0;
				$size = 0;
				logadd("Arquivo não existe: $file");
			} else {
				$total = filesize("$cache_dir/$domain/$file");
				$size = $fileinf[size];
				if ( $total > 0 && !empty($size) && $size > 0) {
					logadd("Tentando download parcial $file ($size/$total)");
				} else {
					$size = 0;
				}
			}
			$site = parse_url($url);
			if ($site["port"] == 0) $site["port"] = 80;
			if (empty($proxy_host)){
				$fIN = fsockopen($site["host"], $site["port"], $errno, $errstr, 30);
			} else {
				$fIN = fsockopen($proxy_host, $proxy_port, $errno, $errstr, 30);
			}
		
			if (!empty($site["query"])){
				$out = "GET ".$site["path"]."?".$site["query"]." HTTP/1.1\r\n";
			}else{
				$out = "GET ".$site["path"]." HTTP/1.1\r\n";
			}
			$out .= "Host: ".$site["host"]."\r\n";
			if ($total>0 && $size > 0) $out .= "Range: bytes=$total-$size\r\n";
			$out .= "Connection: Close\r\n\r\n";
		
			echo "\n".$out;		
			fwrite($fIN, $out);
			logadd("headers enviados: $out");
		
			$body = false;
			$accept_range = false;
			$redirect = false;
			$last_mark = microtime(true);
			$timeout = microtime(true);
			$tbuffer = 0;
			$restart = false;
			while (!feof($fIN) && !$restart) { // while end of file downloading is not found
				if ($body) {
					$buffer = fread($fIN, 1024*$download_speed);
					$tbuffer = strlen($buffer);
				} else {
					$linha = stream_get_line($fIN,1024,"\n");
					echo chop($linha)."\n";
					logadd("header: $linha");
				}
				if (strrpos($linha,"TTP/1") >0 && strrpos($linha," 206") > 0 && !$body) {
					$accept_range = true;
					echo "PARTIAL TRUE!\r\n";
				}
				if (strrpos($linha,"ast-Modified:") > 0 && !$body) {
					$data = substr($linha,16,-1);
					$data = web2mysql($data);
					echo "Data: $data\n";
					$fileinf[modified] = $data;
					write_hash($hash,$fileinf);
				}
				if (strrpos($linha,"ontent-Length:") > 0 && !$body) {
					$sizetmp = explode(' ',$linha);
					$sizetmp = str_replace("\r",'',$sizetmp[1]);
					if ($sizetmp > 0) $size = $sizetmp;
					logadd("Tamanho $file: $size");
					$fileinf[size] = $size;
					write_hash($hash,$fileinf);
					rename(	"$cache_dir/$domain/inf2/".
						mysql2timestamp($fileinf[last_request])."_".
						sprintf('%010.0f',$fileinf[requested])."_".
						sprintf('%010.0f',$fileinf[ndeleted])."_".
						sprintf('%015.0f',0)."_".
						$file,
						"$cache_dir/$domain/inf2/".
						mysql2timestamp($fileinf[last_request])."_".
						sprintf('%010.0f',$fileinf[requested])."_".
						sprintf('%010.0f',$fileinf[ndeleted])."_".
						sprintf('%015.0f',$fileinf[size])."_".
						$file
						);

					// update domain inf
					$hash2 = lock_hash("$cache_dir/$domain/domain.inf",null,false);
					$domaininf = read_hash($hash2);
					$domaininf[files] = $domaininf[files]+1;
					$domaininf[size] = $domaininf[size]+$size;
					$domaininf[hits] = $domaininf[hits]+1;
					write_hash($hash2,$domaininf);
					lock_hash("",$hash2);
				
				}
				if (strrpos($linha,"TTP/1") >0 && (strrpos($linha," 303") > 0 ||strrpos($linha," 302") > 0)&& !$body) {
					$redirect = true;
					echo "SEE OTHER TRUE!\r\n";
				}

				if ((strrpos($linha,"ocation: ") > 0) && !$body && $redirect) {
					$url = substr($linha,10,-1);
					echo "Redirect: $file ($url)\n";
					logadd("Redirect: $file ($url)");
					$restart = true;
				}

				if ($linha == "\r" && !$body && !$redirect) {
					$body = true;
					$exit = true;
					echo "BODY TRUE!\n";
					if ($accept_range) {
						$fOUT = fopen("$cache_dir/$domain/$file", 'a');
						logadd("Partial download: $file ($size/$total)");
					} else {
						$fOUT = fopen("$cache_dir/$domain/$file", 'w');
						$total = 0;
						logadd("Full download: $file ($size/$total)");
					}
				}
				if ($tbuffer > 0 && $body) { // if receive some data
					$timeout = microtime(true);
					$total += $tbuffer;
					fwrite($fOUT,$buffer);
					set_time_limit(1);
				
					if (intval(microtime(true)-$last_mark) > 1) {
						$last_mark = microtime(true);
						if ($streaming) update_db(true);
					}
				}
			
				// if not receive data more then 10 seconds, exit (timeout)
				if (intval(microtime(true)-$timeout) > $download_timeout) {
					update_db();
					logadd("Timeout download: $file ($size/$total)");
					$restart = true;
					$exit = true;
				}
			
				usleep(200000); // its for cpu consuming dont explode!

			}

			fclose($fIN);
			fclose($fOUT);
		} // while exit
		update_db();
		lock_hash("",$hash);
		logadd("END! $file ($total)");
	}
?>
