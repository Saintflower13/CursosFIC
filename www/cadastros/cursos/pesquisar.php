<div class="row">
	<div class="col-xs-12">
		<h3> Pesquisar Cursos: </h3>
			
		<div class="row">
			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="btn_limpar_filtros_cursos" class="btn btn-danger form-control">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<input type="text" id="p_id" class="form-control" placeholder="ID" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-8 col-md-4 no-padding-right">
				<input type="text" id="p_titulo" class="form-control" placeholder="Título" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-4 col-md-2 no-padding-right">
				<select id="p_tipo" class="form-control">
					<option id="tipo_inicial" value="tipo" selected> Tipo       </option>
					<option value="curso">     	   					 Curso      </option>
					<option value="minicurso"> 	   					 Mini Curso </option>
					<option value="palestra">      					 Palestra   </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-3 no-padding-right">
				<select id="p_professor_responsavel" class="form-control">
					<option id="prof_inicial" value="0" selected> Professor </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="filtrar_cursos" class="btn btn-success form-control" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</div>

		<div class="row">
			<div class="tabela-resultados col-xs-12">
				<table id="resultado_cursos" class="table table-striped table-hover table-responsive table-condensed">
					<tr>
						<td class="tabela-resultados-mensagem">
							Nenhum registro para exibir, no momento :) 
						</td>
					</tr>
				</table>	
			</div>
		</div>
	</div>
</div>