<?php 
	$caminho_login = "../index.php";
	include "../../db/base/verifica_sessao.php";
	include "../sidebar_links.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title> Matriculas </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../../lib/BootStrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../lib/BootStrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../../styles/main.css">

	<script src="../../lib/jQuery/jquery.min.js"></script>
	<script src="../../lib/JQuery-UI/jquery-ui.min.js"></script>
	<script src="../../lib/BootStrap/js/bootstrap.min.js"></script>
	<script src="../../scripts/main.js"></script>
	<script src="../../scripts/matriculas.js"></script>
</head>
<body>
	<div class="container-fluid no-padding no-margin">
		<?php $LOGO_CAMINHO = "<img src='../../images/logo_sidebar.png' class='img-responsive logo'>" ?>
		<?php include_once "../global/menus/sidebar.php"; ?>			
		<?php include_once "../global/menus/topbar.php"; ?>

		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-2 corpo">
			<div class="area-principal">
				<div class="pagina-titulo">
					<h3>
						<span class="glyphicon glyphicon-pencil"></span> 
						MATRÍCULAS 
					</h3>
				</div>

				<div id="tabs_matriculas">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#cadastrar"> matricular </a></li>
					</ul>

					<div class="tab-content jumbotron jumbotron-area-principal">
						<!-- TAB PARA CADASTRO -->
						<div id="cadastrar" class="tab-pane fade in active">
							<div class="row">
								<div class="col-xs-12">
									<h3> Matricular Participantes: </h3>
								
									<?php include_once "filtros.php" ?>

									<div class="row div-matriculas-tabelas">
										<?php include_once "matriculados.php" ?>
										<?php include_once "cadastrados.php" ?>	
									</div>

									<div class="form-buttons">
										<div class="form-group">
											<input type="button" id="btn_matricular" class="btn btn-success col-xs-12 col-md-2" value="Enviar">
											<input type="reset" id="resetar_matriculas" class="btn btn-danger col-xs-12 col-md-2" value="Limpar">
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
