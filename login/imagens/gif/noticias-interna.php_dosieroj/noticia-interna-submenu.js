$.validator.setDefaults({
	submitHandler: function() { 
		alert("submitted!"); 
	},
	highlight: function(input) {
		$(input).addClass("ui-state-highlight");
	},
	unhighlight: function(input) {
		$(input).removeClass("ui-state-highlight");
	}
});

function sucessoComentario(data) {
	switch(data){
		case 'captcha':	
			alert("O código informado não confere. Verifique e tente novamente.");
		break;
		case 'sucesso':	
			alert("Seu comentário foi enviado com sucesso.");
			$("#formComentar").resetForm();
		break;
		case 'erro':
			alert("Não foi possível inserir o seu comentário. Por favor, tente mais tarde.");	
		break;
	}
}

function sucessoEnvio(data) {
	switch(data){
		case 'captcha':	
			alert("O código informado não confere. Verifique e tente novamente.");
		break;
		case 'sucesso':	
			alert("Mensagem enviada com sucesso!");
			$("#formEnviar").resetForm();
		break;
		case 'erro':
			alert("Não foi possível enviar para o email. Tente novamente.");	
		break;
	}
	
}

function sucessoNotificacao(data) {
	switch(data){
		case 'captcha':	
			alert("O código informado não confere. Verifique e tente novamente.");
		break;
		case 'sucesso':	
			alert("Sua mensagem será analisada pela redação e os erros confirmados serão corrigidos.\n\nO Diário Online agradece sua colaboração.");
			$("#formCorrigir").resetForm();
		break;
		case 'erro':
			alert("Não foi possível inserir uma notificação. Por favor, tente mais tarde.");	
		break;
	}
}

$(document).ready(function(){
	 // VALIDACAO DOS FORMULARIOS
	$("#formComentar").validate({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				type: 'post',
				url: 'app/painel/modulo-noticia/ferramenta/comentar.php',
				success: sucessoComentario
			});
		},
		rules:{
				nome:{
					required: true
				},
				captcha:{
					required: true
				},
				email:{
					required: true, email: true
				},
				comentario:{
					required: true, maxlength: 1200
				}
			},
			messages:{
				captcha:{required: "O campo código é necessário."},
				nome:{required: "O campo título é necessário."},
				email:{required: "O campo e-mail é necessário.", email: "Informe um e-mail válido."},
				comentario:{required: "O campo conteúdo é necessário.", maxlength: "O campo permitido inserir no máximo 1200 caracteres."}
		}
	});
	
	$("#formLerDepois").validate({
		rules:{
				email:{
					required: true, email: true
	},
				mensagem:{
					required: true
				}
			},
			messages:{
				email:{required: "O campo e-mail é necessário.", email: "Informe um e-mail válido."},
				mensagem:{required: "O campo conteúdo é necessário."}
		}
	});
	
	$("#formEnviar").validate({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				type: 'post',
				url: 'app/painel/modulo-noticia/ferramenta/enviar.php',
				success: sucessoEnvio
			});
		},
		rules:{
				captcha3:{
					required: true
				},
				nome:{
					required: true
				},
				email:{
					required: true, email: true
				},
				emailAmigo:{
					required: true, email: true
				}
			},
			messages:{
				captcha2:{required: "O campo código é necessário."},
				nome:{required: "O campo nome é necessário."},
				email:{required: "O campo e-mail é necessário.", email: "Informe um e-mail válido."},
				emailAmigo:{required: "O campo e-mail do amigo é necessário.", email: "Informe um e-mail válido."},
		}
	});
	
	$("#formCorrigir").validate({
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				type: 'post',
				url: 'app/painel/modulo-noticia/ferramenta/notificar.php',
				success: sucessoNotificacao
			});
		},
		rules:{
				nome:{
					required: true
				},
				captcha2:{
					required: true
				},
				email:{
					required: true, email: true
				},
				notificacao:{
					required: true, maxlength: 1200
				}
			},
			messages:{
				captcha2:{required: "O campo código é necessário."},
				nome:{required: "O campo título é necessário."},
				email:{required: "O campo e-mail é necessário.", email: "Informe um e-mail válido."},
				notificacao:{required: "O campo conteúdo é necessário."}
		}
	});
});

function closeForm(){
	$("#messageSent").show();
	setTimeout('$("#messageSent").hide();$("#contactForm").slideUp()', 2000);
}
