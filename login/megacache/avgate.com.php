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
* Plugin Antivir
* Rewrite urls from avgate.net
* use in ln -s avgate.net freeav.net
* use in ln -s avgate.net freeav.com
* use in ln -s avgate.net avgate.com
* Need to put ".avgate.net" , ".freeav.net" "avgate.com" and "freeav.com" in squid.conf in line "acl store_rewrite_list dstdomain"
*
* @author Bruno Benatto <bruno@foxbyte.com.br>
*/
include_once("functions.php");
$domain = "antivir";
$black_list = array (
                'ave2.info.gz',
                'info-wks-classic-nt-en.info.gz',
                'specvir-nt.info.gz',
                'vdf.info.gz'
);
logadd("IN:($ip)$url");
if ( (preg_match("/\.avgate.net\//", $url,$result)) || (preg_match("/\.freeav\.net\//", $url,$result)) || (preg_match("/\.avgate\.com\//", $url,$result)) || (preg_match("/\.freeav\.com\//", $url,$result)) ){
$file = get_filename($url);
    if ($file != "" && !in_array($file,$black_list)) {
$extfile=trim(str_replace('.','',strtolower(substr($file, -3))));
    if($extfile=='gz') {
        check_file($file,$url,$domain);
}else{
        print "$url\n";
        logadd("OUT:$url ($file)");
}
    }
}else{
        print "$url\n";
        logadd("OUT:$url (dont match)");
}
?>
