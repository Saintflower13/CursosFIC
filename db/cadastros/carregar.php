<?php 
	/** CARREGA AS INFORMAÇÕES PARA PREENCHIMENTO DOS CAMPOS DE CADASTRO (ALTERAÇÃO)
		DA TABELA INFORMADA **/
	include_once "../base/funcoes_uteis.php";

	$tabela = $_POST["tabela"];

	/*********************************************/
	/*************** PARTICIPANTES ***************/
	/*********************************************/
	if ($tabela == "participantes") {
		include_once "../classes/participantes.php";

		$participante     = new Participante();
		$participante->id = $_POST["id"];
		echo $participante->Carregar();

		die();
	}

	/*******************************************/
	/*************** PROFESSORES ***************/
	/*******************************************/
	if ($tabela == "professores") {
		include_once "../classes/professores.php";

		$professor     = new Professor();
		$professor->id = $_POST["id"];
		echo $professor->Carregar();

		die();
	}

	/*******************************************/
	/*************** MATRICULAS ****************/
	/*******************************************/
	if ($tabela == "matriculas") {
		if (isset($_POST["carregar_participantes_cadastrados"])) {
			include_once "../classes/participantes.php";	
			$filtro = $_POST["filtro"];

			$participante 		= new Participante();
			$participante->nome = $filtro; 

			echo $participante->Listar();
			die();
		}

		if (isset($_POST["carregar_cursos"])) {
			include_once "../classes/cursos.php";

			$curso = new Curso;
			echo $curso->Listar();
			die();
		}

		if (isset($_POST["carregar_turmas"])) {
			include_once "../classes/turmas.php";

			$turma 			 = new Turma();
			$turma->id_curso = $_POST["id_curso"];
			$turma->ano      = $_POST["ano"];

			if ($_POST["semestre"] > 0) {
				$turma->semestre = $_POST["semestre"];
			}

			echo $turma->Listar();
			die();
		}

		if (isset($_POST["carregar_turma"])) {
			include_once "../classes/turmas.php";
			
			$turma 	   = new Turma();
			$turma->id = $_POST["id"];		

			echo $turma->Carregar();
			die();
		}

		include_once "../classes/matriculas.php";
		die();
	}

	/********************************************/
	/****************** TURMAS ******************/
	/********************************************/
	if ($tabela == "turmas") {
		include_once "../classes/turmas.php";

		$turma = new Turma();

		if (isset($_POST["carregar_cursos"])) {
			echo $turma->ListarCursos();
			die();
		}

		if (isset($_POST["carregar_professores"])) {
			echo $turma->ListarProfessores();
			die();
		}
		
		$turma->id = $_POST["id"];
		echo $turma->Carregar();
	}


	/********************************************/
	/****************** CURSOS ******************/
	/********************************************/
	if ($tabela == "cursos") {
		include_once "../classes/cursos.php";

		$curso = new Curso();

		if (isset($_POST["carregar_professores"])) {
			echo $curso->ListarProfessores();
			die();
		}

		$curso     = new Curso();
		$curso->id = $_POST["id"];
		echo $curso->Carregar();
	}

	/********************************************/
	/***************** USUÁRIOS *****************/
	/********************************************/
	if ($tabela == "usuarios") {
		include_once "../classes/usuarios.php";		

		$usuario       = new Usuario();
		$usuario->id   = $_POST["id"];

		echo $usuario->Carregar();
		die();
	}

	/***********************************************************/
	/*************** CASO NÃO SEJA TABELA VÁLIDA ***************/
	/***********************************************************/
	DecodeRetornoJSON("false", "Não foi possível identificar a ação a ser realizada.", "");	
?>