<div class="row">
	<div class="col-xs-12">
		<h3> Cadastrar Participante: </h3>

		<form>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-3 col-md-2"> 
					<input type="text" id="c_id" class="form-control apenas-inteiro" placeholder="ID" readonly>
				</div>

				<div class="form-group col-xs-12 col-sm-9 col-md-10">
					<input type="text" id="c_nome" class="form-control" placeholder="Nome" autocomplete="off" required>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-12 col-sm-3 col-md-2">
					<select id="c_tipo_documento" class="form-control">
						<option value="cpf">  CPF   </option>
						<option value="rg">   RG    </option>
						<option value="nasc"> NASC  </option>
					</select>
				</div>

				<div class="form-group col-xs-12 col-sm-9 col-md-10">
					<input type="text" id="c_numero_documento" class="form-control valida-rg" placeholder="Número do documento" autocomplete="off">
				</div>	
			</div>

			<div class="row">
				<div class="form-group col-xs-12">
					<input type="email" id="c_email" class="form-control" placeholder="Email" autocomplete="off">
				</div>
			</div>

			<div class="form-buttons">
				<div class="form-group">
					<input type="button" id="salvar_participante" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
					<input type="reset" id="resetar_participante" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
				</div>
			</div>
		</form>
	</div>
</div>



