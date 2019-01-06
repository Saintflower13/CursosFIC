<div class="row">
	<div class="col-xs-12">
		<h3> Cadastrar Professor: </h3>
								
		<form>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-2">
					<input type="text" id="c_id" class="form-control apenas-inteiro" placeholder="ID" readonly="true">
				</div>

				<div class="form-group col-xs-12 col-sm-10">
					<input type="text" id="c_nome" class="form-control" placeholder="Nome" autocomplete="off">
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-12 col-sm-6 col-md-3">
					<input type="text" id="c_cpf" class="form-control apenas-inteiro" placeholder="CPF" autocomplete="off">
				</div>

				<div class="form-group col-xs-12 col-sm-6 col-md-3">
					<input type="text" id="c_prontuario" class="form-control apenas-inteiro" placeholder="Prontuário" autocomplete="off">
				</div>	

				<div class="form-group col-xs-12 col-sm-6 col-md-3">
					<select id="c_cargo" class="form-control">
						<option id="cargo_padrao" value="cargo" selected>  Cargo          </option>
						<option value="professor">       				   Professor   	  </option>
						<option value="palestrante">     				   Palestrante    </option>
						<option value="tecnico">   	  	 				   Técnico   	  </option>
						<option value="monitor"> 	  					   Monitor        </option>
						<option value="administrativo">					   Administrativo </option>
					</select>
				</div>

				<div class="form-group col-xs-12 col-sm-6 col-md-3">
					<select id="c_tipo" class="form-control">
						<option id="tipo_padrao" value="tipo" selected> Tipo  	   </option>
						<option value="ebtt">      	   					EBTT  	   </option>
						<option value="substutivo">	   					Substutivo </option>
						<option value="voluntario">	   					Voluntário </option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-12">
					<input type="email" id="c_email" class="form-control" placeholder="Email" autocomplete="off">
				</div>
			</div>

			<div class="form-buttons">
				<div class="form-group">
					<input type="button" id="salvar_professor" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
					<input type="reset" id="resetar_professor" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
				</div>
			</div>
		</form>
	</div>
</div>