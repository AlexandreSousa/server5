#!/usr/bin/php
#REV1
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
* Clean Cache 
* Variaveis necessarias no thunder.conf onde disk_limit menor que disk_max
*$disk_limit     = 80; // in percent
* $list_files     = 10; // in number
*
* @author Bruno Benatto <bruno@foxbyte.com.br>
*/
         error_reporting(0);
         $cache_scr = "/etc/squid";
         include ("$cache_scr/thunder.conf");
         include ("$cache_scr/functions.php");

	$diskper=disk_use("$cache_dir");
	$disk=round($diskper,0);
	if ($disk >= $disk_max){
		while ($disk >= $disk_limit) {
		       clear();
		       $diskper=disk_use("$cache_dir");
		       $disk=round($diskper,0);
					     }
				}else {
				exit;
				}
?>
