<?php
	header('Cache-Control: no-cache, must-revalidate'); 
	header('Content-Type: application/json; charset=utf-8');

	include_once "base/executa_query.php";
	include_once "base/funcoes_uteis.php";

	session_start();

	// DESLOGAR
	if (isset($_POST["deslogar"])) {
		unset ($_SESSION['login']);
		unset ($_SESSION['senha']);
		echo DecodeRetornoJSON("true", "", "");
		die();
	}

	$usuario = $_POST["usuario"];
	$senha   = $_POST["senha"];

	if (Trim($usuario) === "" || Trim($senha === "")) {
		echo DecodeRetornoJSON("false", "Usuário ou senha não informados.", "");
		die();
	}

	$sql       = "SELECT id FROM usuarios WHERE NOT excluido AND usuario = '$usuario' AND senha = '" .md5($senha). "';";
	$resultado = QueryPura($sql, "R");
	$resultado = json_decode($resultado);

	if ($resultado->Status && count($resultado->Dados) > 0) {
		$_SESSION['login'] = $usuario;
		$_SESSION['senha'] = $senha;

		echo DecodeRetornoJSON("true", "", "");
		die();
	}

	unset ($_SESSION['login']);
	unset ($_SESSION['senha']);
	echo DecodeRetornoJSON("false", "Usuário e/ou senha incorretos.", "");
?>
