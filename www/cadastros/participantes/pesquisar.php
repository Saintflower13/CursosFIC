<div class="row">
	<div class="col-xs-12">
		<h3> Pesquisar Participantes: </h3>
		
		<div class="row">
			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="btn_limpar_filtros_participantes" class="btn btn-danger form-control">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<input type="text" id="p_id" class="form-control apenas-inteiro" placeholder="ID" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-8 col-md-4 no-padding-right">
				<input type="text" id="p_nome" class="form-control" placeholder="Nome" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-4 col-md-2 no-padding-right">
				<input type="text" id="p_numero_documento" class="form-control valida-rg" placeholder="Nº documento" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-6 col-md-3 no-padding-right">
				<input type="email" id="p_email" class="form-control" placeholder="Email" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="filtrar_participantes" class="btn btn-success form-control" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</div>
		
		<div class="row">
			<div class="tabela-resultados col-xs-12">
				<table id="resultado_participantes" class="table table-striped table-hover table-responsive table-condensed">
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