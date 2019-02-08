// JavaScript Document

function FormataValor(id,tammax,teclapres) {
    
        if(window.event) { // Internet Explorer
         var tecla = teclapres.keyCode; }
        else if(teclapres.which) { // Nestcape / firefox
         var tecla = teclapres.which;
        }
    

vr = document.getElementById(id).value;
vr = vr.toString().replace( "/", "" );
vr = vr.toString().replace( "/", "" );
vr = vr.toString().replace( ",", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
vr = vr.toString().replace( ".", "" );
tam = vr.length;

if (tam < tammax && tecla != 8){ tam = vr.length + 1; }

if (tecla == 8 ){ tam = tam - 1; }

if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
if ( tam <= 2 ){
document.getElementById(id).value = vr; }
if ( (tam > 2) && (tam <= 5) ){
document.getElementById(id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 6) && (tam <= 8) ){
document.getElementById(id).value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 9) && (tam <= 11) ){
document.getElementById(id).value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 12) && (tam <= 14) ){
document.getElementById(id).value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }
if ( (tam >= 15) && (tam <= 17) ){
document.getElementById(id).value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );}
}
}
</script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	

