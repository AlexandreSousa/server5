<?PHP
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
* Functions used by system
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 
	umask(0);
	// constants
	define('size',0);
	define('downloaded',1);
	define('modified',2);
	define('requested',3);
	define('last_request',4);
	define('deleted',5);
	define('ndeleted',6);
	define('last_downloaded' ,7);
	define('files' ,1);
	define('hits' ,2);
	
	function logadd($line) {
		include("thunder.conf");
		if ($logadd_on) {
			syslog(LOG_INFO, date(" H:i:s ").getmypid()." ".$line);
		}
	}
	
	function disk_use($dir){
	    $df = disk_free_space($dir);
	    $dt = disk_total_space($dir);
	    $du = $dt-$df;
	    return ($du / $dt)*100;
	}

	function mkinf($file){
		if (!file_exists($file)){
			$hash = lock_hash($file);
			$domaininf = array(0,0,0);
			write_hash($hash,$domaininf);
			lock_hash("",$hash);
		}
	}
		
	function lock_hash($file,$hash=null,$shared=true){
		if ($shared) {$lock = LOCK_SH;} else {$lock = LOCK_EX;}
		if (is_null($hash)) {
			if (!file_exists($file)) touch($file);
			$hash = fopen ($file,'r+');
			$canWrite = flock($hash, $lock);
			while (!$canWrite) {
				logadd("Bloqueado: ".basename($file));
				$bloqueado =true;
				usleep(round(rand(0, 100)*1000));
				$canWrite = flock($hash, $lock);
			}
			if ($bloqueado) logadd("DesBloqueado: ".basename($file));
			return $hash;
		} else {
			fclose($hash);
		}
	}
	

	function write_hash($hash,$datas){
		if (is_array($datas)){
			fseek($hash,0);
			foreach ($datas as $key => $value) fwrite($hash,"$value;");
		}
	}
	
	function read_hash($hash) {
		if (!is_null($hash)){
			fseek($hash,0);
			while(!feof($hash))
				$newString .= fread($hash,1024);
			$lines = explode (";",$newString);
			foreach ($lines as $line){
				if ($line != "") 
					$arraytmp[] = $line;
			}
			return $arraytmp;
		}
	}

	function grab_domain($url) {
		$url = explode("/",$url); 
		$url = $url[2];
		$url = explode(".",$url); 
		$ext = array_search("com",$url);
		if ($ext === false) $ext = array_search("net",$url);
		if ($ext === false || $ext == count($url)-1) {
			return $url[count($url)-2].".".$url[count($url)-1];
		} else {
			return $url[count($url)-3].".".$url[count($url)-2].".".$url[count($url)-1];
		}
	}
	
	function mysql2timestamp($datetime){
		$datetime = explode(" ",$datetime);
		$date = explode("-",$datetime[0]);
		$time = explode(":",$datetime[1]);
		return mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
	}
	
	function web2mysql($data){
		$mes = array(	"Jan" => 1,
				"Feb" => 2,
				"Mar" => 3,
				"Apr" => 4,
				"May" => 5,
				"Jun" => 6,       
				"Jul" => 7,       
				"Aug" => 8,       
				"Sep" => 9,       
				"Oct" => 10,       
				"Nov" => 11,       
				"Dec" => 12);
		$data = explode(" ",$data);
		return $data[3]."-".$mes[$data[2]]."-".$data[1]." ".$data[4];
	}

	function find_domains($finddir,$prefix=""){
		$domains = array();
		$dh = opendir($finddir);
		while(($dir = readdir($dh)) !== false) {
			if (is_dir("$finddir/$dir") && $dir != ".." && $dir != "." ) {
				$dh2 = opendir("$finddir/$dir");
				$foundinfdir = false;
				while(($dir2 = readdir($dh2)) !== false) 
					if ($dir2 == "inf" || $dir2 == "inf2") {
						$foundinfdir = true;
						break;
					}
				closedir($dh2);
				
				if ($foundinfdir) {
					$domains[] = $prefix.$dir;
				} else {
					foreach (find_domains("$finddir/$dir","$dir/") as $dir2)
						$domains[] = $prefix.$dir2;
				}
		
			}
		}
		return $domains;
	}
	
	function check_file($file,$url,$domain, $streaming=true) {
		include("thunder.conf");
	
		if ((!file_exists("$cache_dir/$domain/inf/$file")) or 
		    (!file_exists("$cache_dir/$domain/$file")) ){
		    
		    	if (!file_exists("$cache_dir/$domain/inf/$file")) {
				
				$fileinf = array(
							0,
							0,
							'1980-01-01 00:00:00',
							0,
							date("Y-m-d H:i:s"),
							0,
							0,
							date("Y-m-d H:i:s")
						);
				if (!is_dir("$cache_dir/$domain/inf")){
					mkdir("$cache_dir/$domain/inf",0777,true);
					mkdir("$cache_dir/$domain/inf2",0777,true);
					mkinf("$cache_dir/$domain/domain.inf");
					//mkinf("$cache_dir/global.inf");
				}
				$hash = lock_hash("$cache_dir/$domain/inf/$file");
				write_hash($hash,$fileinf);
				lock_hash("",$hash);
				touch(	"$cache_dir/$domain/inf2/".
					mysql2timestamp($fileinf[last_request])."_".
					sprintf('%010.0f',$fileinf[requested])."_".
					sprintf('%010.0f',$fileinf[ndeleted])."_".
					sprintf('%015.0f',$fileinf[size])."_".
					$file
					);
				
			} else {
				$hash = lock_hash("$cache_dir/$domain/inf/$file");
				$fileinf = read_hash($hash);
				$datanova = date("Y-m-d H:i:s");
				rename(	"$cache_dir/$domain/inf2/".
					mysql2timestamp($fileinf[last_request])."_".
					sprintf('%010.0f',$fileinf[requested])."_".
					sprintf('%010.0f',$fileinf[ndeleted])."_".
					sprintf('%015.0f',$fileinf[size])."_".
					$file,
					"$cache_dir/$domain/inf2/".
					mysql2timestamp($datanova)."_".
					sprintf('%010.0f',$fileinf[requested]+1)."_".
					sprintf('%010.0f',$fileinf[ndeleted])."_".
					sprintf('%015.0f',$fileinf[size])."_".
					$file
					);
				$fileinf[requested] = $fileinf[requested] + 1;
				$fileinf[deleted] = 0;
				$fileinf[downloaded] = 0;
				$fileinf[last_request] = $datanova;
				$fileinf[last_downloaded] = $datanova;
				write_hash($hash,$fileinf);
				lock_hash("",$hash);
			}
			logadd("Disk in use: ".disk_use("$cache_dir/$domain/")."%");
			if (disk_use("$cache_dir/$domain/") <= $disk_max){
				// download in background
				system("($cache_scr/downloader.php \"$url\" $domain \"$file\" $streaming) > /dev/null &");
				// rewrite url
				if ($streaming) {
					print $redir."$cache_url.php?file=$file&domain=$domain\n";
					logadd("MISS:$redir $cache_url.php?file=$file&domain=$domain");
				} else {
					print "$url\n";
					logadd("MISS:$url (no streaming)");
				}
			} else {
				print "$url\n";
				logadd("OUT:$url (disk max)");
			}

		} else {
			// if file exists
			$hash = lock_hash("$cache_dir/$domain/inf/$file");
			$fileinf = read_hash($hash);
			
			if ($fileinf[size] == $fileinf[downloaded] && $fileinf[size] > 0){
				// if download is completed
				print $redir."$cache_url/$domain/$file\n";
				logadd("HIT:$redir $cache_url/$domain/$file");

				// update hit
				$datanova = date("Y-m-d H:i:s");
				rename(	"$cache_dir/$domain/inf2/".
					mysql2timestamp($fileinf[last_request])."_".
					sprintf('%010.0f',$fileinf[requested])."_".
					sprintf('%010.0f',$fileinf[ndeleted])."_".
					sprintf('%015.0f',$fileinf[size])."_".
					$file,
					"$cache_dir/$domain/inf2/".
					mysql2timestamp($datanova)."_".
					sprintf('%010.0f',$fileinf[requested]+1)."_".
					sprintf('%010.0f',$fileinf[ndeleted])."_".
					sprintf('%015.0f',$fileinf[size])."_".
					$file
					);
				$fileinf[last_request] = $datanova;
				$fileinf[requested] = $fileinf[requested] + 1;
				write_hash($hash,$fileinf);
				
				// update domain inf
				$hash2 = lock_hash("$cache_dir/$domain/domain.inf",null,false);
				$domaininf = read_hash($hash2);
				$domaininf[hits] = $domaininf[hits]+1;
				write_hash($hash2,$domaininf);
				lock_hash("",$hash2);
				
			} else { // while downloading or timeout download
				$timeout = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) - mysql2timestamp($fileinf[last_downloaded]) ;
				logadd("Timeout: $timeout\n");
				if ($timeout < 10 && $streaming) {
					print $redir."$cache_url.php?file=$file&domain=$domain\n";
					logadd("WHILE:$redir $cache_url.php?file=$file&domain=$domain");
				} else if ($timeout >= 10 && $streaming){
					// update last request
					$fileinf[last_downloaded] = date("Y-m-d H:i:s");
					write_hash($hash,$fileinf);

					// download in background
					system("($cache_scr/downloader.php \"$url\" $domain \"$file\") > /dev/null &");
					// rewrite url
					print $redir."$cache_url.php?file=$file&domain=$domain\n";
					logadd("TIMEOUT:$redir $cache_url.php?file=$file&domain=$domain");
				} else if ($timeout >= 30 && !$streaming){
					// download in background
					system("($cache_scr/downloader.php \"$url\" $domain \"$file\" $streaming) > /dev/null &");
					print "$url\n";
					logadd("TIMEOUT:$url (no streaming)");
				}
			}
			lock_hash("",$hash);

		}

	}	
	

?>
