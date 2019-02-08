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
* Loader plugins
* Load include files by domains, this is core of system
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

error_reporting(0);
include_once ("functions.php");
include ("thunder.conf");


$f = fopen('php://stdin','r');
while (!isset($exit)) { // 
	$url = fgets($f);
	$url = explode(" ",$url);
	$ip =  $url[1];
	$url = $url[0];
	$url = explode("\n",$url);
	$url = $url[0];

	if ($url == "") { // squid exiting...
		logadd("loader exiting...");
		exit;
	} else {
		$domain = grab_domain($url).".php";
		if (file_exists("$cache_scr/$domain")) {
			include($domain);
		} else {
			print "$url\n";
			logadd("OUT:$url ($cache_scr/$domain)");		
		}
	}
}
fclose($f);
?>
