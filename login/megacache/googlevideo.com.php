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
* Plugin youtube.com
* Cache flash video files from youtube and googlevideo
* Need to put ".youtube.com" in squid.conf in line "acl store_rewrite_list dstdomain"
* best if you create symbolic link named "googlevideo.com.php" and put in squid.conf ".googlevideo.com"
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 
// confs
$save_quality = false;
$domain = "youtube";

include_once("youtube.com.funcs.php");

logadd("IN:($ip)$url");

if ((preg_match("/\.googlevideo\.com/", $url,$result)) or (preg_match("/\.youtube\.com/", $url,$result))){
	// get  videoid
	$videoid = get_videoid($url);

	// get quality
	if ($save_quality) {
		$file=get_quality($url)."$videoid.flv";
	}else{
		$file="$videoid.flv";
	}
     // check if url need to pass

if ( ($file != ".flv") and (strrpos($url,"/get_video?") > 0) or (strrpos($url,".googlevideo.com") > 0 and (strrpos($url,"videoplayback")) >0 and (strrpos($url,"&id=")) >0 )) {
		check_file($file,$url,$domain);
	} else { // dont find file, repass url
		print "$url\n";
		logadd("OUT:$url ($file)");
	}
} else {
	// url not match
	print "$url\n";
	logadd("OUT:$url (dont match)");
}
  
?>
