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
* Plugin functions youtube.com
* Functions used by youtube.com.php
*
* @author rodrigo manga <rodrigomanga@yahoo.com.br>
*/ 

	function get_videoid($url) {
		$return = "";
		$url = preg_replace("/\?/","&",$url);
		$url = explode("/",$url);
		$url = $url[3];
		$url = explode("&",$url);
		
		foreach ($url as $valor){
			$valor = explode("=",$valor);
			if ($valor[0] == "id" || $valor[0] == "video_id") {
				$return = $valor[1];
				break;
			}
		}
		return $return;
	}

	function get_quality($url) {
		$return = "";
		$url = preg_replace("/\?/","&",$url);
		$url = explode("/",$url);
		$url = $url[3];
		$url = explode("&",$url);
		
		foreach ($url as $valor){
			$valor = explode("=",$valor);
			if ($valor[0] == "fmt") {
				$return = $valor[1];
				break;
			}
		}
		return $return;
	}
?>
