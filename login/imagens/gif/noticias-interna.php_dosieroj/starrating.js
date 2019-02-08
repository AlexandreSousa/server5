// JavaScript Document
// get rating function
var nIdNoticia;

function getRating(nId){
	nIdNoticia = nId;
	//alert(nIdNoticia);
	$.ajax({
		type: "POST",
		url: "app/painel/modulo-noticia/ferramenta/votar.php",
		data: ({sOP : 'Recuperar', nIdNoticia : nIdNoticia}),
		cache: false,
		async: false,
		success: function(result) {
			//alert(result);
			// apply star rating to element
			$("#current-rating").css({ width: "" + result + "%" });
		}
	});
}

$(document).ready(function() {
	// link handler
	$('#ratelinks li a').click(function(){
		$.ajax({
			type: "POST",
			url: "app/painel/modulo-noticia/ferramenta/votar.php",
			//data: "rating="+$(this).text()+"&do=rate",
			data: ({sOP : 'Votar', nIdNoticia : nIdNoticia, rating: $(this).text() }),
			cache: false,
			async: false,
			success: function(result) {
				// remove #ratelinks element to prevent another rate
				$("#ratelinks").remove();
				// get rating after click
				getRating(nIdNoticia);
			}
		});
	});
});
