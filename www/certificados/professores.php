<h3> Enviar Certificados: </h3>

<div class="row">
	<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
		<button id="btn_limpar_filtros_professores" class="btn btn-danger form-control">
			<span class="glyphicon glyphicon-remove"></span>
		</button>
	</div>

	<div class="form-group col-xs-12 col-sm-2 no-padding-right">
		<select id="p_professor_semestre" class="form-control">
			<option id="sem_inicial_prof" value="0"> Semestre </option>
			<option value="1">        				 1        </option>
			<option value="2"> 		  				 2	      </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-1 no-padding-right">
		<input type="text" id="p_professor_ano" class="form-control" placeholder="Ano" autocomplete="off">
	</div>

	<div class="form-group col-xs-12 col-sm-3 no-padding-right">
		<select id="p_professor_curso" class="form-control">
			<option id="curso_inicial_prof" value="0"> Curso </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-2 no-padding-right">
		<select id="p_professor_turma" class="form-control">
			<option id="turma_inicial_prof" value="0"> Turma </option>
			<option  value="0"> asdasd </option>
		</select>
	</div>

	<div class="form-group col-xs-12 col-sm-2 no-padding-right">
		<input type="text" id="p_professor" class="form-control" placeholder="Professor" autocomplete="off">
	</div>

	<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right matricula-header-filtro">
		<button id="selecionar_professores" class="btn btn-success form-control" >
			<span class="glyphicon glyphicon-ok"></span>
		</button>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 col-sm-8 container-interior-padrao">
			<h4 class="titulo"> Professores: </h4>
			<span>
				<label class="subtitulo">
					<input id="mostrar_professores_sem_email" type="checkbox" value="1"> Mostrar professores sem email cadastrado 
				</label> 
			</span>

			<table id="tbl_professores" class="table tabela-certificados table-striped table-hover table-responsive table-condensed">
				<tr>
					<td class="checkbox col-xs-12">
						<label>
							<input id="1" type="checkbox" value="1"> 001 - Emanuelle Christine de Santana Flôr - manu714074@gmail.com 
						</label>
					</td>
				</tr>
			</table>
		</div>

		<div class="col-xs-12 col-sm-4 container-interior-padrao">
			<h4 class="color-darkred"> Professores sem email cadastrado: </h4>

			<table id="tbl_professores_sem_email" class="table tabela-certificados table-striped table-hover table-responsive table-condensed fonte-menor">
				<tr>
					<td class="col-xs-12">
						001 - Emanuelle Christine de Santana Flôr  
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<!--
<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 panel-mensagem">
			Emails enviados com sucess
		</div> 
	</div>
</div>
-->

<div class="row">
	<div class="form-buttons col-xs-12">
		<div class="form-group">
			<input type="submit" id="btn_professor_enviar_certificado" class="btn btn-success col-xs-12 col-sm-4 col-md-3" value="Enviar Certificados">
			<input type="submit" id="btn_professor_imprimir_certificados" class="btn btn-success col-xs-12 col-sm-4 col-md-3 margin-responsiva" value="Imprimir Certificados">
			<input type="reset" id="btn_resetar_professor" class="btn btn-danger col-xs-12 col-sm-2 col-md-2" value="Limpar">
		</div>
	</div>
</div>