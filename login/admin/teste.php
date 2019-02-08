<html>
<script src="jquery.js" type="text/javascript"></script>
  <head>
    <title></title>
    <meta content="">
    <style></style>
  </head>
  <body>
  <script type="text/javascript">
  $(document).ready(function(){
  $("#endereco").click(function(evento){
  		if ($("#endereco").attr("checked")){
			$(".alvo").css("display", "block");
		}else{
				$(".alvo").css("display", "none");
			}
		});
	});
	
</script>
  
  <label><input type="checkbox" name="endereco" id="endereco" value="1" />teste</label>
  
  <div style="display: none; margin-top:12px" class="alvo">
  
  <input name="" type="button" />
  
  </div>
  </body>
</html>