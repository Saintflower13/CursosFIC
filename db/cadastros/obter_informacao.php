<?php
	/** RETORNA INFORAÇÕES SIMPLES (UM ÚNICO CAMPO) DO BANCO BASEADO NOS CAMPOS:
		TABELA, CAMPO E CONDIÇÃO **/

	include_once "../base/executa_query.php";

	/*********** VERIFICA CAMPOS OBRIGATÓRIOS ***********/
	if (!isset($_POST["tabela"]) || !isset($_POST["campo"]) || 
		!isset($_POST["condicao"]) || !isset($_POST["valor_padrao"])) {
		echo "false";
		die();
	}

	$tabela   	  = $_POST["tabela"];
	$campo   	  = $_POST["campo"];
	$condicao 	  = $_POST["condicao"];
	$valor_padrao = $_POST["valor_padrao"];

	$retorno = json_decode(Get($tabela, $campo, $condicao), true);

	if (!$retorno["Status"]) {
		echo $valor_padrao;
		die();
	}

	$dados = $retorno["Dados"];
	echo $dados[0][$campo];
?>