<div class="row">
	<div class="col-xs-12">
		<h3> Cadastrar Turma: </h3>
						
		<div id="tabs_turmas_interior">
			<ul class="nav nav-pills nav-pills-interior">
				<li class="active"><a data-toggle="pill" href="#informacoes_basicas"> Informações Básicas </a></li>
				<li><a data-toggle="pill" href="#docentes"> Docentes </a></li>
			</ul>

			<div class="tab-content tab-content-interior">
				<div id="informacoes_basicas" class="tab-pane fade in active">
					<form>
						<div class="row">
							<div class="form-group col-xs-12 col-sm-3 col-md-2">
								<input type="text" id="c_id" class="form-control" placeholder="ID" readonly="true">
							</div>

							<div class="form-group col-xs-12 col-sm-9 col-md-6">
								<input type="text" id="c_descricao" class="form-control" placeholder="Descrição" autocomplete="off">
							</div>

							<div class="form-group col-xs-12 col-sm-6 col-md-2">
								<select id="c_semestre" class="form-control">
									<option id="sem_inicial" value="0"> Semestre </option>
									<option value="1"> 					1 		 </option>
									<option value="2"> 					2		 </option>
								</select>
							</div>

							<div class="form-group col-xs-12 col-sm-6 col-md-2">
								<input type="text" id="c_ano" class="form-control apenas-inteiro" placeholder="Ano" autocomplete="off">
							</div>	
						</div>

						<div class="row">
							<div class="form-group col-xs-12 col-sm-6 col-md-3">
								<label for="c_data_inicial" class="lb01"> Data inicial: </label>
								<input type="date" id="c_data_inicial" class="form-control">
							</div>	

							<div class="form-group col-xs-12 col-sm-6 col-md-3">
								<label for="c_data_final" class="lb01"> Data final: </label>
								<input type="date" id="c_data_final" class="form-control">
							</div>	

							<div class="form-group col-xs-12 col-sm-6 col-md-2">
								<label for="c_carga_horaria" class="lb01"> C. horária: </label>
								<input type="number" min="0" id="c_carga_horaria" class="form-control">
							</div>

							<div class="form-group col-xs-12 col-sm-3 col-md-2">
								<label for="c_horario_inicial" class="lb01"> H. Inicial: </label>
								<input type="time" id="c_horario_inicial" class="form-control">
							</div>

							<div class="form-group col-xs-12 col-sm-3 col-md-2">
								<label for="c_horario_final" class="lb01"> H. Final: </label>
								<input type="time" id="c_horario_final" class="form-control">
							</div>
						</div>

						<div class="row">
							<div class="form-group col-xs-12 col-sm-7">
								<label for="c_curso" class="lb01"> Curso: </label>
								<select id="c_curso" class="form-control">
									<option id="curso_inicial" value="0"> Curso </option>
								</select>
							</div>

							<div class="form-group col-xs-2 col-sm-1">
								<label for="dias" class="lb01"> Dias de aula: </label>
								<input type="hidden" id="dias">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_domingo" class="lb01"> Dom </label>
								<input type="checkbox" id="c_dias_domingo" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_segunda" class="lb01"> Seg </label>
								<input type="checkbox" id="c_dias_segunda" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_terca" class="lb01"> Ter </label>
								<input type="checkbox" id="c_dias_terca" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_quarta" class="lb01"> Qua </label>
								<input type="checkbox" id="c_dias_quarta" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_quinta" class="lb01"> Qui </label>
								<input type="checkbox" id="c_dias_quinta" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_sexta" class="lb01"> Sex </label>
								<input type="checkbox" id="c_dias_sexta" class="form-control">
							</div>

							<div class="form-group col-xs-3 col-sm-1 div-checkbox">
								<label for="c_dias_sabado" class="lb01"> Sab </label>
								<input type="checkbox" id="c_dias_sabado" class="form-control">
							</div>
						</div>
					</form>
				</div>
				<!-- FIM CADASTRO --->

				<div id="docentes" class="tab-pane fade in">
					<div class="row">
						<div class="form-group col-xs-12 no-margin-bottom">
							<h4> Adicionar Docente: </h4>
			     		</div>
					</div>

					<div class="row">
						<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
							<button id="btn_limpar_filtros_docentes" class="btn btn-danger form-control">
								<span class="glyphicon glyphicon-remove"></span>
							</button>
						</div>

						<div class="form-group col-xs-12 col-sm-4 col-md-5 no-padding-right">
							<select id="c_docentes" class="form-control">
								<option id="docente_titulo" value="0"> Docente </option>
							</select>
						</div>

						<div class="form-group col-xs-12 col-sm-4 col-md-5 no-padding-right">
							<input type="number" min="1" id="c_docente_carga_horaria" class="form-control" placeholder="Carga Horária">
						</div>

						<div class="form-group col-xs-12 col-sm-2 col-sm-2 col-md-1 no-padding-right">
							<button id="adicionar_docente" class="btn btn-success form-control" >
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-xs-12 tabela-resultados tabela-resultados-sm">
							<table id="docentes_cadastrados" class="table table-striped table-hover table-responsive table-condensed">
								<tr class="tabela-nenhum-registro">
									<td class="tabela-resultados-mensagem">
										Nenhum registro para exibir, no momento :) 
									</td>
								</tr>
								<!--<tr>
									<th> ID </th>
									<th> Docentes Cadastrados </th>
									<th> Carga Horária </th>
									<th></th>
								</tr>
								<tr>
									<th> 0001 </th>
									<td> Emanuelle Christine de Santana Flôr </td>
									<td> 12 horas </td>
									<td><span class="glyphicon glyphicon-remove color-darkred"></span></td>
								</tr> -->
							</table>
						</div>
					</div>
				</div>
				<!-- FIM DOCENTES -->
			</div>

			<div class="form-buttons">
				<div class="form-group">
					<input type="button" id="salvar_turma" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
					<input type="reset" id="resetar_turma" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
				</div>
			</div>	
		</div>
	</div>
</div>