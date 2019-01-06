<div class="col-xs-12 col-sm-6 div-tabela-matriculas">
	<h4> Participantes Cadastrados </h4>

	<div class="form-group tabela-matriculas">
		<div class="row">
		<div class="form-group col-xs-12 col-md-2 no-padding-right">
			<button id="btn_limpar_filtros_participantes" class="btn btn-danger form-control input-sm">
				<span class="glyphicon glyphicon-remove"></span>
			</button>
		</div>

		<div class="form-group col-xs-12 col-md-8 no-padding-right">
			<input id="p_participantes" type="text" placeholder="Nome" class="form-control input-sm">
		</div>

		<div class="form-group col-xs-12 col-md-2 no-padding-right">
			<button id="filtrar_participantes" class="form-control btn btn-success input-sm">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</div>
	</div>

		<div class="row">
			<div class="col-xs-12">
				<table id="participantes_cadastrados" class="table table-striped table-hover table-responsive table-condensed">
					<tr class="tabela-nenhum-registro">
						<td class="tabela-resultados-mensagem">
							Nenhum registro para exibir, no momento :) 
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>