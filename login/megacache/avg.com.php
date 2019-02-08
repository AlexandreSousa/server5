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
* Plugin Avg
* Rewrite urls from avg.com
* Need to put ".avg.com" in squid.conf in line "acl store_rewrite_list dstdomain"
* best if you create symbolic link named "grisoft.com.php" and put in squid.conf ".grisoft.com"
*
* @author Bruno Benatto <bruno@foxbyte.com.br>
*/
//include_once("avg.com.funcs.php");
include_once("functions.php");
$domain = "avg";
logadd("IN:($ip)$url");

if ( (preg_match("/\.avg\.com\//", $url,$result))) {
        // get file name
        $file = get_filename($url);
$extfile=trim(str_replace('.','',strtolower(substr($file, -4))));
if($extfile=='bin') {
check_file($file,$url,$domain);
}else if($extfile=='exe') {
check_file($file,$url,$domain);
} else {
        // url not match
        print "$url\n";
        logadd("OUT:$url (dont match)");
}
}

?>
