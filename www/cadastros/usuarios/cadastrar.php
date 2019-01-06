<div class="row">
	<div class="col-xs-12">
		<h3> Cadastrar Usuário: </h3>
							
		<form>
			<div class="row">
				<div class="col-xs-12 col-sm-2">
					<div class="form-group">
						<input type="text" id="c_id" class="form-control apenas-inteiro" placeholder="ID" readonly required>
					</div>
				</div>

				<div class="col-xs-12 col-sm-10">
					<div class="form-group">
						<input type="text" id="c_usuario" class="form-control" placeholder="Usuário" autocomplete="off" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<input type="password" id="c_senha" class="form-control" placeholder="Senha" autocomplete="off" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<input type="password" id="c_senha_confirmar" class="form-control" placeholder="Confirme a senha" autocomplete="off" required>
					</div>
				</div>
			</div>

			<div class="form-buttons">
				<div class="form-group">
					<input type="button" id="salvar_usuario" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
					<input type="reset" id="resetar_usuario" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
				</div>
			</div>
		</form>
	</div>
</div>