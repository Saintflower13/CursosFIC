<div class="row">
	<div class="col-xs-12">
		<h3> Pesquisar Usuários: </h3>
			
		<div class="row">
			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="btn_limpar_filtros_usuarios" class="btn btn-danger form-control">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>

			<div class="form-group col-xs-12 col-sm-8 col-md-10 no-padding-right">
				<input type="text" id="p_usuario" class="form-control" placeholder="Usuário" autocomplete="off">
			</div>

			<div class="form-group col-xs-12 col-sm-2 col-md-1 no-padding-right">
				<button id="filtrar_usuarios" class="btn btn-success form-control" >
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		</div>
			
		<div class="row">
			<div class="tabela-resultados col-xs-12">
				<table id="resultado_usuarios" class="table table-striped table-hover table-responsive table-condensed">
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