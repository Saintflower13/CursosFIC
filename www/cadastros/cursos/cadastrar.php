<div class="row">
	<div class="col-xs-12">
		<h3> Cadastrar Curso: </h3>
						
		<form>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-2">
					<input type="text" id="c_id" class="form-control" placeholder="ID" readonly="true">
				</div>

				<div class="form-group col-xs-12 col-sm-10">
					<input type="text" id="c_titulo" class="form-control" placeholder="Título" autocomplete="off">
				</div>

			</div>

			<div class="row">
				<div class="form-group col-xs-12 col-sm-3 col-md-2">
					<select id="c_tipo" class="form-control">
						<option value="tipo"> Tipo       </option>
						<option value="0">    Curso      </option>
						<option value="1"> 	  Mini Curso </option>
						<option value="2"> 	  Palestra   </option>
					</select>
				</div>

				<div class="form-group col-xs-12 col-sm-9 col-md-10">
					<input type="text" id="c_descricao" class="form-control" placeholder="Descrição" autocomplete="off">
				</div>	
			</div>

			<div class="row">
				<div class="form-group col-xs-12 col-sm-3 col-md-2">
					<select id="c_campus" class="form-control">
						<option value="campus"> Câmpus   </option>
						<option value="0"> 	    IFSP-CJO </option>
						<option value="1"> 	 	EaD      </option>
					</select>
				</div>

				<div class="form-group col-xs-12 col-sm-9 col-md-10">
					<select id="c_professor_responsavel" class="form-control">
						<option value="0"> Professor Responsável </option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-12">
					<label for="c_ementa" class="lb01"> Ementa: </label>
					<textarea id="c_ementa" class="form-control resize-vertical" rows="4" autocomplete="off"></textarea>
				</div>
			</div>

			<div class="form-buttons">
				<div class="form-group">
					<input type="button" id="salvar_curso" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
					<input type="reset" id="resetar_curso" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
				</div>
			</div>
		</form>
	</div>
</div>