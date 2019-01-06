<?php 
	$caminho_login = "../";
	include "../../db/base/verifica_sessao.php";
	include "../sidebar_links.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title> Certificados </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../../lib/BootStrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../lib/BootStrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../../styles/main.css">

	<script src="../../lib/jQuery/jquery.min.js"></script>
	<script src="../../lib/JQuery-UI/jquery-ui.min.js"></script>
	<script src="../../lib/BootStrap/js/bootstrap.min.js"></script>
	<script src="../../scripts/main.js"></script>
	<script src="../../scripts/certificados.js"></script>
	<script src="../../scripts/manipula_certificados.js"></script>
</head>
<body>
	<div class="loading">
		<h2> Os certificados estão sendo enviados. Aguarde :) </h2>
	</div>

	<div class="container-fluid no-padding no-margin">
		<?php $LOGO_CAMINHO = "<img src='../../images/logo_sidebar.png' class='img-responsive logo'>" ?>
		<?php include_once "../global/menus/sidebar.php"; ?>			
		<?php include_once "../global/menus/topbar.php"; ?>

		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-2 corpo">
			<div class="area-principal">
				<div class="pagina-titulo">
					<h3 id="Certificados">
						<span class="glyphicon glyphicon-education"></span> 
						CERTIFICADOS 
					</h3>
				</div>

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#participantes"> participantes </a></li>
					<li style="display: none;"><a data-toggle="tab" href="#professores"> professores </a></li>
					<li><a data-toggle="tab" href="#atualizar"> atualizar </a></li>
				</ul>

				<div class="tab-content jumbotron jumbotron-area-principal">
					<!-- TAB ENVIAR CERTIFICADOS PARTICIPANTES -->
					<div id="participantes" class="tab-pane fade in active">
						<?php include "participantes.php" ?>
					</div>
					
					<!-- TAB ENVIAR CERTIFICADOS PROFESSORES -->						
					<div style="display: none;" id="professores" class="tab-pane fade in">
						<?php include "professores.php" ?>
					</div> 

					<!-- TAB ATUALIZAR -->
					<div id="atualizar" class="tab-pane fade in">
						<?php include "atualizar.php" ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
