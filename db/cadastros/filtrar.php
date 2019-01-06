<?php
	/** FILTRA E RETORNA REGISTROS BASEADOS NOS FILTROS E TABELA INFORMADOS  **/
	include_once "../base/funcoes_uteis.php";

	/*********** VERIFICA CAMPOS OBRIGATÓRIOS ***********/
	if (!isset($_POST["tabela"])) {
		DecodeRetornoJSON("false", "Valores incompletos.", "");
		die();
	}

	$tabela = $_POST["tabela"];


	/*********************************************/
	/*************** PARTICIPANTES ***************/
	/*********************************************/
	if ($tabela == "participantes") {
		include_once "../classes/participantes.php";		

		$participante     				= new Participante();
		$participante->id 				= $_POST["id"];
		$participante->nome 			= $_POST["nome"];
		$participante->numero_documento = $_POST["numero_documento"];
		$participante->email 			= $_POST["email"];

		echo $participante->Listar();
		die();
	}


	/*******************************************/
	/*************** PROFESSORES ***************/
	/*******************************************/
	if ($tabela == "professores") {
		include_once "../classes/professores.php";		

		$professor     		   = new Professor();
		$professor->id 		   = $_POST["id"];
		$professor->nome 	   = $_POST["nome"];
		$professor->cpf 	   = $_POST["cpf"];
		$professor->prontuario = $_POST["prontuario"];
		$professor->cargo 	   = $_POST["cargo"];

		echo $professor->Listar();
		die();
	}

	/*******************************************/
	/*************** MATRICULAS ****************/
	/*******************************************/
	if ($tabela == "matriculas") {
		if (isset($_POST["carregar_participates"])) {
			include_once "../classes/matriculas.php";		


			$matriculas     	  = new Matricula();
			$matriculas->id_turma = $_POST["id"];

			echo $matriculas->ListarParticipantes();
			die();
		}
	}

	/*******************************************/
	/***************** TURMAS ******************/
	/*******************************************/
	if ($tabela == "turmas") {
		include_once "../classes/turmas.php";		

		$turma     		  = new Turma();
		$turma->id 		  = $_POST["id"];
		$turma->id_curso  = $_POST["curso"];
		$turma->semestre  = $_POST["semestre"];
		$turma->ano 	  = $_POST["ano"];
		$turma->descricao = $_POST["descricao"];

		echo $turma->Listar();
		die();
	}

	/*******************************************/
	/***************** CURSOS ******************/
	/*******************************************/
	if ($tabela == "cursos") {
		include_once "../classes/cursos.php";		

		$curso     		     = new Curso();
		$curso->id 		     = $_POST["id"];
		$curso->titulo 	     = $_POST["titulo"];
		$curso->tipo 	     = $_POST["tipo"];
		$curso->professor_id = $_POST["professor_id"];

		echo $curso->Listar();
		die();
	}

	/********************************************/
	/***************** USUÁRIOS *****************/
	/********************************************/
	if ($tabela == "usuarios") {
		include_once "../classes/usuarios.php";		

		$usuario          = new Usuario();
		$usuario->usuario = $_POST["usuario"];

		echo $usuario->Listar();
		die();
	}

	/***********************************************************/
	/*************** CASO NÃO SEJA TABELA VÁLIDA ***************/
	/***********************************************************/
	DecodeRetornoJSON("false", "Não foi possível identificar a ação a ser realizada.", "");

?>