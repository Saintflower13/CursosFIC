<?php
	/** EXCLUI OU CANCELA REGISTRO A PARTIR DA TABELA E ID INFORMADOS **/
	include_once "../base/funcoes_uteis.php";

	/*********** VERIFICA CAMPOS OBRIGATÓRIOS ***********/
	if (!isset($_POST["tabela"]) || !isset($_POST["id"])) {
		DecodeRetornoJSON("false", "Valores incompletos.", "");
		die();
	}

	$tabela = $_POST["tabela"];
	$id     = $_POST["id"];

	/*********************************************/
	/*************** PARTICIPANTES ***************/
	/*********************************************/
	if ($tabela == "participantes") {
		include_once "../classes/participantes.php";		

		$participante     = new Participante();
		$participante->id = $id;
		echo $participante->Excluir();

		die();
	}


	/*******************************************/
	/*************** PROFESSORES ***************/
	/*******************************************/
	if ($tabela == "professores") {
		include_once "../classes/professores.php";		

		$professor     = new Professor();
		$professor->id = $id;
		echo $professor->Excluir();

		die();
	}

	/********************************************/
	/***************** MATRICULAS ***************/
	/********************************************/
	if ($tabela == "matriculas") {
		include_once "../classes/matriculas.php";		

		$matricula     = new Matricula();
		$matricula->id = $id;

		echo $matricula->Cancelar();
		die();
	}

	/********************************************/
	/****************** TURMAS ******************/
	/********************************************/
	if ($tabela == "turmas") {
		include_once "../classes/turmas.php";		

		$turma     = new Turma();
		$turma->id = $id;

		if (isset($_POST["cancelar_docente"])) {
			echo $turma->CancelarDocente();	
			die();
		}
		echo $turma->Cancelar();
		die();
	}


	/********************************************/
	/***************** USUÁRIOS *****************/
	/********************************************/
	if ($tabela == "cursos") {
		include_once "../classes/cursos.php";		

		$curso       = new Curso();
		$curso->id   = $id;

		echo $curso->Cancelar();
		die();
	}

	/********************************************/
	/************** CERTIFICADOS ****************/
	/********************************************/
	if ($tabela == "certificados") {
		include_once "../classes/certificados.php";		

		echo $_POST["url"]; 

		if (!$_POST["url"]) {
			die();
		}

		$certificado          = new Certificado();
		$certificado->caminho = $_POST["url"];

		echo $certificado->Deletar();
		die();
	}

	/********************************************/
	/***************** USUÁRIOS *****************/
	/********************************************/
	if ($tabela == "usuarios") {
		include_once "../classes/usuarios.php";		

		$usuario       = new Usuario();
		$usuario->id   = $id;

		echo $usuario->Excluir();
		die();
	}


	/***********************************************************/
	/*************** CASO NÃO SEJA TABELA VÁLIDA ***************/
	/***********************************************************/
	DecodeRetornoJSON("false", "Não foi possível identificar a ação a ser realizada.", "");
?>













