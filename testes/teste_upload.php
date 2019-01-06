<html> 
<body> 
	<form action="../db/certificado_att_part.php" method="Post" enctype="multipart/form-data" target="_blank"> 
		<input type="hidden" name="img_certificado" value="bg_frente" />
		<input type="file" name="Arquivo" id="Arquivo"><br> 

		<input type="submit" value="Enviar"> 
		<input type="reset" value="Apagar"> 
	</form> 

	<br><br>
	<form action="banco/envia_img.php" method="Post" enctype="multipart/form-data" target="_blank"> 
		<input type="hidden" name="img_certificado" value="bg_tras" />
		<input type="file" name="Arquivo" id="Arquivo"><br> 
		<input type="submit" value="Enviar"> 
		<input type="reset" value="Apagar"> 
	</form> 
</body> 
</html>

