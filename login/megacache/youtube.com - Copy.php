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
	if ( ($file != ".flv") and (strrpos($url,"/get_video?") > 0) or 
	     (strrpos($url,".googlevideo.com") > 0 and (strrpos($url,"videoplayback?id=")) >0)) {
		check_file($file,$url,$domain);
		
		//Abre a url
$homepage = file_get_contents($url);
//Lê a url
$codigo = htmlentities($homepage);
// início da tag
$nome_i = "VideoCategoryLink')";
// fim da tag
$nome_f = "</a><br/>";
$inicio = strpos($homepage, $nome_i);
$fim = strpos($homepage, $nome_f);
$posicoes = $fim-strlen($nome_f)-$inicio;
$nome = substr($homepage, $inicio+strlen($nome_i)+3, $posicoes);
// início da tag
$cat_i = "<title>";
// fim da tag
$cat_f = "</title>";
$inicio = strpos($homepage, $cat_i);
$fim = strpos($homepage, $cat_f);
$posicoes = $fim-strlen($cat_f)+1-$inicio;
$categoria = substr($homepage, $inicio+strlen($cat_i)+9, $posicoes);

// Variaveis de gravação no banco
$titulo = sqlite_escape_string($nome);
$nome = sqlite_escape_string($file);
$categ = sqlite_escape_string($categoria);
$scrarquivo = sqlite_escape_string("/youtube/" + $file);
$scrthumb = sqlite_escape_string("http://i.ytimg.com/vi/" + $file + "/1.jpg");

//caso a base de dados não exista, ele tenta criar
if ($db = sqlite_open("mediacenter.db", 0666, $error)) {
};
$tabela = 'youtube';
// Quonta quantas tabelas existem com o nome da variavel
$result = sqlite_query($db,"SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name='$tabela'");
// Transforma em inteiro e retorna 0 para falso e 1 para verdadeiro
$count = intval(sqlite_fetch_single($result));
// verifica se não existe tabela
if($count == 0){
	//cria a tabela
	$create = 'create table youtube (' .' id integer primary key, ' . ' titulo varchar(255), ' .' nome varchar(255), ' .' novoarquivo varchar(255), ' .' scrarquivo varchar(255), ' .' scrthumb varchar(255), ' .' categoria varchar(255)) ';
	//Executa o comando criar tabela
	sqlite_query($db, $create);
	//insere dados
	$insert = 'INSERT INTO youtube VALUES(null, \''.$titulo.'\',\''.$nome.'\',\''.$scrarquivo.'\',\''.$scrthumb.'\',\''.$categ.'\')';
	//Executa o comando para inserir os dados
	sqlite_query($db, $insert);
}//fecha o if
	else
		{
		//insere dados
		$insert = 'INSERT INTO youtube VALUES(null, \''.$titulo.'\',\''.$nome.'\',\''.$scrarquivo.'\',\''.$scrthumb.'\',\''.$categ.'\')';
		//Executa o comando para inserir os dados
		sqlite_query($db, $insert);
		// cria tabela
		$sql1 = sqlite_query($db, "SELECT * FROM youtube");
		//visualiza os dados gravados
		while ($i = sqlite_fetch_array($sql1)) {
			echo "<br><br>";
			echo "ID: ".$i['id']."<br>";
			echo "Nome: ".$i['nome'];
		}//fecha while

}// fecha o else
// fecha conexão
sqlite_close($db);
		
		
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
