<?php 
	$caminho_login = "../../index.php";
	include "../../../db/base/verifica_sessao.php";
	include "../sidebar_links.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title> Cadastro Participante </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="../../../lib/BootStrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../lib/BootStrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../../../styles/main.css">

	<script src="../../../lib/jQuery/jquery.min.js"></script>
	<script src="../../../lib/JQuery-UI/jquery-ui.min.js"></script>
	<script src="../../../lib/BootStrap/js/bootstrap.min.js"></script>
	<script src="../../../scripts/main.js"></script>
	<script src="../../../scripts/participantes.js"></script>
</head>
<body>
	<div class="container-fluid no-padding no-margin">
		<?php $LOGO_CAMINHO = "<img src='../../../images/logo_sidebar.png' class='img-responsive logo'>" ?>
		<?php include_once "../../global/menus/sidebar.php"; ?>			
		<?php include_once "../../global/menus/topbar.php"; ?>

		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-2 corpo">
			<div class="area-principal">
				<div class="pagina-titulo">
					<h3>
						<span class="glyphicon glyphicon-user"></span> 
						PARTICIPANTES 
					</h3>
				</div>

				<div id="tabs_participantes">
					<ul class="nav nav-tabs">
						<li class="active"><a id="tab_cadastrar" data-toggle="tab" href="#cadastrar"> cadastrar </a></li>
						<li><a data-toggle="tab" href="#pesquisar"> pesquisar </a></li> <!--id="tab_pesquisar" -->
					</ul>

					<div class="tab-content jumbotron jumbotron-area-principal">
						<!-- TAB PARA CADASTRO -->
						<div id="cadastrar" class="tab-pane fade in active">
							<?php include_once "cadastrar.php" ?>
						</div>

						<!-- TAB PARA PESQUISA -->
						<div id="pesquisar" class="tab-pane fade">
							<?php include_once "pesquisar.php" ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
