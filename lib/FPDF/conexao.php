<?php
	// VARIÁVEIS PARA CONEXAO
	$servidor = "localhost";
	$usuario  = "root";
	$senha    = "";
	$banco    = "cursos_fic";

	// CRIANDO CONEXAO
	$conexao  = mysqli_connect($servidor, $usuario, $senha, $banco);

	// TESTANDO CONEXAO
	if (!$conexao) {
	    die("Falha na conexão: " . mysqli_connect_error());
	}

	mysqli_set_charset($conexao, "utf8");
?>