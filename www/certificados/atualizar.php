<h3> Selecione as imagens: </h3>

<div class="row">						
	<div class="col-xs-12">
		<div class="row">
			<form method="POST" action="../../db/certificados/participante_atualizar.php" enctype="multipart/form-data" target="_blank" class="form-atualizar-certificado col-xs-12">
				<div>
					<label> Frente: </label>
					<!-- ESSE É O QUE VAI APARECER EM $_POST. VALUE SERÁ RESPONSÁVEL POR DIFERENCIAR OS ARQUIVOS DE FRENTE E VERSO -->
					<input type="hidden" name="arquivo" value="bg_frente" /> 
					<!-- ESSE É O QUE VAI APARECER EM $_FILES -->
					<input type="file" id="cert_input_frente" name="imagem" class="input-file-certificado"> 
					<span id="cert_frente_ok" class="glyphicon glyphicon-ok"></span>	
				</div>

				<input type="submit" class="btn btn-success col-xs-12 col-sm-2 margin-responsiva" value="Enviar"> 
				<input type="reset" id="cert_frente_limpar" class="btn btn-danger col-xs-12 col-sm-2" value="Limpar"> 
			</form>
		</div>
		<br>

		<div class="row">
			<form action="../../db/certificados/participante_atualizar.php" method="POST" enctype="multipart/form-data" target="_blank" class="form-atualizar-certificado col-xs-12">
				<div>
					<label> Verso: </label>
					<input type="hidden" name="arquivo" value="bg_verso" />
					<input type="file" id="cert_input_verso" name="imagem" class="input-file-certificado">
					<span id="cert_verso_ok" class="glyphicon glyphicon-ok"></span>	
				</div>

				<input type="submit" class="btn btn-success col-xs-12 col-sm-2 margin-responsiva" value="Enviar"> 
				<input type="reset" id="cert_verso_limpar" class="btn btn-danger col-xs-12 col-sm-2" value="Limpar"> 
			</form>
		</div>
	</div>
</div>