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
* Plugin functions windowsupdate.com
* Functions used by windowsupdate.com.php
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

	function get_filename($url) {
		$url = preg_replace("/\?/","&",$url);
		$url = preg_replace("/&/","//",$url);
		
		if (preg_match("/[0-9]{10}$/", $url, $resultado)) {
			// metadados
			$url = explode("/",$url);
			return $url[(count($url)-3)];
		} else {
			// arquivos do winupdate
			$url = explode("/",$url);
			return $url[(count($url)-1)];
		}

	}
?>
