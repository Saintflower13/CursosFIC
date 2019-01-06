<div class="row">
	<div class="col-xs-12">
		<h3> Pesquisar Turmas: </h3>
						
		<div class="row">
			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="btn_limpar_filtros_turmas" class="btn btn-danger form-control">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-3 col-md-1 no-padding-right">
				<input type="text" id="p_id" class="form-control apenas-inteiro" placeholder="ID" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-7 col-md-3 no-padding-right">
				<select id="p_curso" class="form-control">
					<option id="p_curso_inicial" value="0"> Curso </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-3 col-md-2 no-padding-right">
				<select id="p_semestre" class="form-control">
					<option id="p_sem_inicial" value="0"> Semestre </option>
					<option value="1">                    1        </option>
					<option value="2"> 	            	  2		   </option>
				</select>
			</div>

			<div class="form-group col-xs-12 col-sm-3 col-md-2 no-padding-right">
				<input type="text" id="p_ano" class="form-control apenas-inteiro" placeholder="Ano" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-4 col-md-2 no-padding-right">
				<input type="text" id="p_descricao" class="form-control" placeholder="Descrição" autocomplete="off">
			</div>	

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="filtrar_turmas" class="btn btn-success form-control" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</div>
		
		<div class="row">
			<div class="tabela-resultados col-xs-12">
				<table id="resultado_turmas" class="table table-striped table-hover table-responsive table-condensed">
					<tr>
						<td class="tabela-resultados-mensagem">
							Nenhum registro para exibir, no momento :) 
						</td>
					</tr>
					<!--
					<tr>
						<th> ID </th>
						<th> Curso </th>
						<th> Sem/Ano </th>
						<th> Descrição </th>
						<th> Horário </th>
					</tr>
					<tr>
						<td> 0001 </td>
						<td> Japonês Básico </td>
						<td> 1º Sem/2018 </td>
						<td> - </td>
						<td> 10:00 </td>
					</tr>-->
				</table>	
			</div>
		</div>
	</div>
</div>