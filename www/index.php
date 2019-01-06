<!DOCTYPE html>
<html>
<head>
	<title> Login </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../lib/BootStrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/main.css">

	<script src="../lib/JQuery/jquery.min.js"></script>
	<script src="../lib/BootStrap/js/bootstrap.min.js"></script>
	<script src="../scripts/main.js"></script>
	<script src="../scripts/login.js"></script>
</head>
<body class="body-login">
	<div class="container">
		<div class="col-xs-10 col-sm-6 col-md-4 div-centralizar jumbotron jumbotron-padrao">
			<!-- LOGO -->
			<div class="col-xs-12 col-sm-10 col-sm-offset-1">
				<img src="../images/ifsp.png" class="logo-login div-centralizar-horizontal img-responsive">
			</div>

			<div class="logo-descricao">
				<span> Cursos FIC </span>
			</div>

			<!-- FORMULÁRIO DE LOGIN -->
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 form-login">
				<form id="form_login" name="form_login">
			  		<div class="form-group">
			  			<input type="text" id="login_usuario" name="login_usuario" class="form-control" placeholder="Usuário" autocomplete="off">
			  		</div>

			  		<div class="form-group">
			  			<input type="password" id="login_senha" name="login_senha" class="form-control" placeholder="Senha" autocomplete="off">
			  		</div>

			  		<div class="form-group">
			  			<input type="button" id="btn_logar" name="btn_logar" class="btn btn-success col-xs-12" value="Logar">
			  		</div>
			  	</form>
			</div>
		</div>

		<div class="jumbotron jumbotron-padrao div-centralizar-horizontal">
			<span> Instituto Federal de Educação, Ciência e Tecnologia de São Paulo - Câmpus Campos do Jordão </span>
		</div>
	</div>
</body>
</html>