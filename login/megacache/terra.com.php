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
* Plugin terra.com
* Cache flash video files from terra
* Need to put ".terra.com" in squid.conf in line "acl store_rewrite_list dstdomain"
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

// confs
$domain = "terra";

include_once("terra.com.funcs.php");

logadd("IN:($ip)$url");

// get  videoid
$file = get_terraid($url);

// check if url need to pass
if ( ($file != "") and (strrpos($url,".flv?") > 0) ) {
	check_file($file,$url,$domain);
} else { // dont find file, repass url
	print "$url\n";
	logadd("OUT:$url ($file)");
}
  
?>
