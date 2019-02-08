var nIndex = 0; 
var vsTamanho = new Array( '10pt','11pt','12pt','13pt','14pt','16pt','18pt' );

function zoomTexto(Id, Incremento) {
	   nIndex = nIndex + Incremento;
	   if(nIndex < 0){
		   nIndex = 0;
	   }
	   if(nIndex >= vsTamanho.length){
		   nIndex = vsTamanho.length-1;
	   }
	   
	   var oDiv = document.getElementById(Id);
	   oDiv.style.fontSize = vsTamanho[nIndex];
}
