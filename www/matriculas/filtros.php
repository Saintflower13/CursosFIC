<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="btn_limpar_filtros_matriculas" class="btn btn-danger form-control">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-4 col-md-2 no-padding-right matricula-header-filtro">
				<select id="p_semestre" class="form-control">
					<option  id="sem_inicial" value="0"> Semestre </option>
					<option value="1">        			 1        </option>
					<option value="2"> 		  			 2        </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-2 no-padding-right matricula-header-filtro">
				<input type="text" id="p_ano" class="form-control" placeholder="Ano" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-4 no-padding-right matricula-header-filtro">
				<select id="p_curso" class="form-control">
					<option id="curso_inicial" value="0"> Curso </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-4 col-md-2 no-padding-right matricula-header-filtro">
				<select id="p_turma" class="form-control">
					<option id="turma_inicial" value="0"> Turma </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right matricula-header-filtro">
				<button id="selecionar_turma" class="btn btn-success form-control" >
					<span class="glyphicon glyphicon-ok"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-10 col-md-11 matricula-header-turma" style="display: none;">
				Turma: <span id="turma_selecionada"> [CURSO] 0001 - DESCRIÇÃO, 1SEM/2018, 13:00, SEG-TER-QUA  </span>
			</div>
		</div>
	</div>
</div>