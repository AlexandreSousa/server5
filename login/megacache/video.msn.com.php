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
* Plugin msn.com.php
* Cache files from video.msn.com
* Need to put ".video.msn.com" in squid.conf in line "acl store_rewrite_list dstdomain"
*
* @author Jo�o Ferraz Primo <jfprimo@gmail.com>
*/

$streaming   = true;

$domain   = "msn/video";

############## Dont change nothing after this! ##############

logadd("IN:($ip)$url");

if (strpos($url,"catalog.video.msn.com") !== false && strpos($url,"share") !== false) {
   $domain = $domain;
   $file = explode("/",$url);
   $file = $file[count($file)-1];
   check_file($file,$url,$domain, $streaming);
   
} else {
   print "$url\n";
   logadd("OUT:$url (dont match)");
}
?>
