<?php	
 //Verificar ip dinamico 
if ( $row_qr_ids_pega['a_ip'] == nao)
	{
	
	// Verfica se o Login existe
	if ( $row_RSUsuario['login'] == $login )
 		  { 

   // Verifica a Senha
  		 if ( $row_RSUsuario['senha'] == $senha )
    		  {

      // Verfica se o Cliente esta bloqueado
   		   if ( $row_RSMaclist['situacao'] == a )
    		     {

         // Verifica o IP
     		    if ( $ip == $ip )
       			     { 
		
	    // Remove as regras de redirecionamento pra Pagina de Login
	  
	   shell_exec("sudo iptables -t nat -A POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -A FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -t nat -I PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
	   
	   //Travando o MAX x IP
	    shell_exec("sudo iptables -I FORWARD -d 0/0 -s $ip -m mac --mac-source $mac -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I FORWARD -s 0/0 -d $ip -mstate --state ESTABLISHED,RELATED -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -A POSTROUTING -s $ip -d 0/0 -j SNAT --to $servidor 2>&1 1> /dev/null");
	   
	   //Setando regra para monitoramento de trafego 
	   shell_exec("sudo iptables -A control -d $ip 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -A control -s $ip 2>&1 1> /dev/null");
         
        //REGRAS PARA LIBERA CONECTIVIDADE SOCIAL DA CAIXA
		   
		shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
		   
		   
// Verifica o Proxy Ativo
         if ( $row_qr_ids_pega['proxy'] == sim )
            { 
	    // Redireciona o trafego da porta 80 pra porta do proxy Squid
	    shell_exec("/usr/bin/sudo /sbin/iptables -t nat -I PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid");
}
	    $error_log = "LOGADO COM SUCESSO - $data - $hora - Usuario: $login IP: $ip MAC: $mac \r\n";
	    fwrite($abrir, $error_log);
	    fclose($abrir);
		$proxy = $row_qr_ids_pega['proxy'];
		//$registrar = echo "$ip $mac $login $senha";
		 include "class/logar.php";
        // Redireciona o Cliente pro site definido como página inicial
           header("Location:ok.php");
	    // Redireciona o Cliente pro site do provedor
	    // header("Location:http://$siteprovedor"); 

	    }
       else {  
            $error_log = "ERRO - IP INCORRETO - $data - $hora - Usuario: $login IP: $ip MAC: $mac \r\n";
            fwrite($abrir, $error_log);
            fclose($abrir);
            header("Location:index.php?url=$site&erro=config");
            }

         }
    else { 
         $error_log = "ERRO - USUARIO BLOQUEADO - $data - $hora - Usuario: $login Status: $status IP: $ip MAC: $mac \r\n";
         fwrite($abrir, $error_log);
         fclose($abrir);
         header("Location:ndex.php?url=$site&erro=block");
         }

       }
  else {
       $error_log = "ERRO - SENHA INCORRETA - $data - $hora - Usuario: $login Senha: $senha IP: $ip MAC: $mac \r\n";
       fwrite($abrir, $error_log);
       fclose($abrir);
       header("Location:index.php?url=$site&erro=senha");	   
       }

     }
else { 
     $error_log = "ERRO - USUARIO INCORRETO - $data - $hora - Usuario: $login IP: $ip MAC: $macarp \r\n ";
     fwrite($abrir, $error_log);
     fclose($abrir);
     header("Location:index.php?url=$site&erro=login");
     }
	
	
	}
	else{
	// Verfica se o Login existe
	if ( $row_RSUsuario['login'] == $login )
 		  { 

   // Verifica a Senha
  		 if ( $row_RSUsuario['senha'] == $senha )
    		  {

      // Verfica se o Cliente esta bloqueado
   		   if ( $row_RSMaclist['situacao'] == a )
    		     {

         // Verifica o IP
     		    if ( $row_RSMaclist['ip'] == $ip )
       			     { 
		
	    // Remove as regras de redirecionamento pra Pagina de Login
	  
	   shell_exec("sudo iptables -t nat -A POSTROUTING -s $ip -j MASQUERADE 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -A FORWARD -s $ip -j ACCEPT 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -t nat -I PREROUTING -s $ip -j ACCEPT 2>&1 1> /dev/null");
	   
	   //Travando o MAX x IP
	    shell_exec("sudo iptables -I FORWARD -d 0/0 -s $ip -m mac --mac-source $mac -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I FORWARD -s 0/0 -d $ip -mstate --state ESTABLISHED,RELATED -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -A POSTROUTING -s $ip -d 0/0 -j SNAT --to $servidor 2>&1 1> /dev/null");
	   
	   //Setando regra para monitoramento de trafego 
	   shell_exec("sudo iptables -A control -d $ip 2>&1 1> /dev/null");
	   shell_exec("sudo iptables -A control -s $ip 2>&1 1> /dev/null");
	   
	   
	   	shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -I INPUT -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.173.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.174.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
	    shell_exec("sudo iptables -t nat -I PREROUTING -p tcp -s $ip -m mac --mac-source $mac -d 200.201.166.0/24 --dport 80 -j ACCEPT 2>&1 1> /dev/null");
         
           
// Verifica o Proxy Ativo
         if ( $row_qr_ids_pega['proxy'] == sim )
            { 
	    // Redireciona o trafego da porta 80 pra porta do proxy Squid
	    shell_exec("/usr/bin/sudo /sbin/iptables -t nat -I PREROUTING -s $ip -p tcp --dport 80 -j REDIRECT --to-port $squid");
}
	    $error_log = "LOGADO COM SUCESSO - $data - $hora - Usuario: $login IP: $ip MAC: $mac \r\n";
	    fwrite($abrir, $error_log);
	    fclose($abrir);
		$proxy = $row_qr_ids_pega['proxy'];
		//$registrar = echo "$ip $mac $login $senha";
		 include "class/logar.php";
        // Redireciona o Cliente pro site definido como página inicial
           header("Location:ok.php");
	    // Redireciona o Cliente pro site do provedor
	    // header("Location:http://$siteprovedor"); 

	    }
       else {  
            $error_log = "ERRO - IP INCORRETO - $data - $hora - Usuario: $login IP: $ip MAC: $mac \r\n";
            fwrite($abrir, $error_log);
            fclose($abrir);
            header("Location:index.php?url=$site&erro=config");
            }

         }
    else { 
         $error_log = "ERRO - USUARIO BLOQUEADO - $data - $hora - Usuario: $login Status: $status IP: $ip MAC: $mac \r\n";
         fwrite($abrir, $error_log);
         fclose($abrir);
         header("Location:ndex.php?url=$site&erro=block");
         }

       }
  else {
       $error_log = "ERRO - SENHA INCORRETA - $data - $hora - Usuario: $login Senha: $senha IP: $ip MAC: $mac \r\n";
       fwrite($abrir, $error_log);
       fclose($abrir);
       header("Location:index.php?url=$site&erro=senha");	   
       }

     }
else { 
     $error_log = "ERRO - USUARIO INCORRETO - $data - $hora - Usuario: $login IP: $ip MAC: $macarp \r\n ";
     fwrite($abrir, $error_log);
     fclose($abrir);
     header("Location:index.php?url=$site&erro=login");
     }
	}
?>