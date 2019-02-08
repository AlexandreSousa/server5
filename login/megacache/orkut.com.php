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
* Plugin Orkut
* Store or rewrite images from orkut.com
* Need to put ".orkut.com" in squid.conf in line "acl store_rewrite_list dstdomain"
*
* @author Luiz Biazus <luiz@biazus.com> and Rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

#Domain Vars (if u use $domain_dir true setup it!
$only_rewrite	=	false; // if true rewrite the url, if false, store images
$streaming	= 	false; // if true, streaming while download, if false, redirect client to url and download in background
$domain_small 	= 	"orkut/small";
$domain_mili 	= 	"orkut/mili";
$domain_klein   =       "orkut/klein";
$domain_mittel  =       "orkut/mittel";
$domain_albums 	= 	"orkut/albums";
$domain_photos 	= 	"orkut/photos";

#dont change nothing after this!##############



logadd("IN:($ip)$url");

if (preg_match("/^http:\/\/img[2-9]\.orkut\.com.*/", $url, $result) && $only_rewrite) {
	$url = preg_replace("/\/img[0-9]\./", "/img1.", $url);
	print "$url\n";
	logadd("OUT:$url");
} else if (strpos($url,"orkut.com/") !== false && strpos($url,"images/small/") !== false && !$only_rewrite) {
	$domain = $domain_small;
	$file = explode("/",$url);
	$file = $file[count($file)-2]."_".$file[count($file)-1]; //.".jpg";
	check_file($file,$url,$domain, $streaming);

} else if (strpos($url,"orkut.com/") !== false && strpos($url,"images/klein/") !== false && !$only_rewrite) {
        $domain = $domain_klein;
        $file = explode("/",$url);
        $file = $file[count($file)-3]."_".$file[count($file)-2]."_".$file[count($file)-1]; //.".jpg";
        check_file($file,$url,$domain, $streaming);

} else if (strpos($url,"orkut.com/") !== false && strpos($url,"images/mittel/") !== false && !$only_rewrite) {
        $domain = $domain_mittel;
        $file = explode("/",$url);
        $file = $file[count($file)-3]."_".$file[count($file)-2]."_".$file[count($file)-1]; //.".jpg";
        check_file($file,$url,$domain, $streaming);

} else if (strpos($url,"orkut.com/") !== false && strpos($url,"images/milieu/") !== false  && !$only_rewrite) {
	$domain = $domain_mili;
	$file = explode(".jpg",$url);
	$file = explode("/",$file[count($file)-2]);
	$file = $file[count($file)-5]."_".$file[count($file)-4]."_".$file[count($file)-3]."_".$file[count($file)-1].".jpg";
	check_file($file,$url,$domain, $streaming);
} else if (strpos($url,"orkut.com/") !== false && strpos($url,"/albums") !== false  && !$only_rewrite) {
	$domain = $domain_albums;
	$file = explode("/",$url);
	$file = $file[count($file)-1];
	check_file($file,$url,$domain, $streaming);
} else if (strpos($url,"orkut.com/") !== false && strpos($url,"/photos") !== false  && !$only_rewrite) {
   $domain = $domain_photos;
   $file = explode("/",$url);
   $file = $file[count($file)-2]."_".$file[count($file)-1];
   check_file($file,$url,$domain, $streaming);

	
} else {
	print "$url\n";
	logadd("OUT:$url (dont match)");
}

?>
