<?php
	/** EFETUA AS FUNÇÕES DE CADASTRO E ALTERAÇÃO DE CADASTRO DO SISTEMA,
		BASEADO NA TABELA INFORMADA. **/
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
		$participante->tipo_documento 	= $_POST["tipo_documento"];
		$participante->numero_documento = $_POST["numero_documento"];
		$participante->email 			= $_POST["email"];

		// CAMPOS OBRIGATÓRIOS
		if ($participante->nome === "") {
			echo DecodeRetornoJSON("false", "Informe o nome da(o) participante.", "");
			die();
		}

		// SETA SE É CADASTRO OU ALTERAÇÃO
		$alteracao = ($participante->id !== "");

		// VERIFICA SE É CADASTRO OU ALTERAÇÃO
		if ($alteracao) {
			echo $participante->Editar();
		} else {
			echo $participante->Cadastrar();
		}

		die();
	}


	/********************************************/
	/****************** TURMAS ******************/
	/********************************************/
	if ($tabela == "turmas") {
		include_once "../classes/turmas.php";		

		$turma          	           = new Turma();
 		$turma->docentes   			   = new Docente();

		$turma->id      	           = $_POST["id"];
		$turma->id_curso 	  		   = $_POST["id_curso"];
		$turma->descricao     		   = $_POST["descricao"];
		$turma->semestre     		   = $_POST["semestre"];
		$turma->ano            		   = $_POST["ano"];
		$turma->data_inicio            = $_POST["data_inicio"];
		$turma->data_fim        	   = $_POST["data_fim"];
		$turma->carga_horaria          = $_POST["carga_horaria"];
		$turma->docentes->arr_docentes = $_POST["docentes"];
		$turma->id_dias				   = $_POST["id_dias"];
		$turma->dias 				   = $_POST["dias"];
		$turma->horario_inicial		   = $_POST["horario_inicial"];
		$turma->horario_final		   = $_POST["horario_final"];

		$mensagem = $turma->ValidarCampos();

		if ($mensagem != "") {
			echo DecodeRetornoJSON("false", $mensagem, "");
			die();
		}

		// SETA SE É CADASTRO OU ALTERAÇÃO
		$alteracao = ($turma->id !== "");

		// VERIFICA SE É CADASTRO OU ALTERAÇÃO
		if ($alteracao) {
			echo $turma->Editar();
		} else {
			echo $turma->Cadastrar();
		}

		die();
	}

	/*********************************************/
	/*************** PARTICIPANTES ***************/
	/*********************************************/
	if ($tabela == "matriculas") {
		include_once "../classes/matriculas.php";

		$matricula     	     	  = new Matricula();
		$matricula->id_turma 	  = $_POST["id_turma"];

		// CAMPOS OBRIGATÓRIOS
		if (!$matricula->id_turma) {
			echo DecodeRetornoJSON("false", "Não foi possível identificar a turma.", "");
			die();
		}

		if (!isset($_POST["participantes"])) {
			echo DecodeRetornoJSON("true", "", "");
			die();	
		}

		$matricula->participantes = $_POST["participantes"];

		echo $matricula->Matricular();
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
		$professor->email 	   = $_POST["email"];
		$professor->cargo 	   = $_POST["cargo"];
		$professor->tipo  	   = $_POST["tipo"];

		// CAMPOS OBRIGATÓRIOS
		if ($professor->nome === "") {
			echo DecodeRetornoJSON("false", "Informe o nome do(a) professor(a).", "");
			die();
		}

		// SETA SE É CADASTRO OU ALTERAÇÃO
		$alteracao = ($professor->id !== "");

		// VERIFICA SE É CADASTRO OU ALTERAÇÃO
		if ($alteracao) {
			echo $professor->Editar();
		} else {
			echo $professor->Cadastrar();
		}

		die();
	}
	


	/*******************************************/
	/***************** CURSOS ******************/
	/*******************************************/
	if ($tabela == "cursos") {
		include_once "../classes/cursos.php";

		$curso 			     = new Curso();
		$curso->id           = $_POST["id"];
		$curso->titulo       = $_POST["titulo"];
		$curso->tipo         = $_POST["tipo"];
		$curso->descricao    = $_POST["descricao"];
		$curso->campus       = $_POST["campus"];
		$curso->professor_id = $_POST["professor"];
		$curso->ementa       = $_POST["ementa"];


		// CAMPOS OBRIGATÓRIOS
		if ($curso->titulo === "") {
			echo DecodeRetornoJSON("false", "Informe o título do curso.", "");
			die();
		}

		if ($curso->professor_id == 0) {
			echo DecodeRetornoJSON("false", "Escolha um(a) professor(a) responsável.", "");
			die();
		}

		// SETA SE É CADASTRO OU ALTERAÇÃO
		$alteracao = ($curso->id !== "");

		// VERIFICA SE É CADASTRO OU ALTERAÇÃO
		if ($alteracao) {
			echo $curso->Editar();
		} else {
			echo $curso->Cadastrar();
		}

		die();
	}



	/********************************************/
	/***************** USUÁRIOS *****************/
	/********************************************/
	if ($tabela == "usuarios") {
		include_once "../classes/usuarios.php";		

		$usuario          		  = new Usuario();
		$usuario->id      		  = $_POST["id"];
		$usuario->usuario 		  = $_POST["usuario"];
		$usuario->senha      	  = $_POST["senha"];
		$usuario->senha_confirmar = $_POST["senha_confirmar"];


		// CAMPOS OBRIGATÓRIOS
		if ($usuario->usuario === "" || $usuario->senha === "" || $usuario->senha_confirmar === "") {
			echo DecodeRetornoJSON("false", "Todos os campos são de preenchimento obrigatório.", "");
			die();
		}

		// SETA SE É CADASTRO OU ALTERAÇÃO
		$alteracao = ($usuario->id !== "");

		// VERIFICA SE É CADASTRO OU ALTERAÇÃO
		if ($alteracao) {
			echo $usuario->Editar();
		} else {
			echo $usuario->Cadastrar();
		}

		die();
	}



	/***********************************************************/
	/*************** CASO NÃO SEJA TABELA VÁLIDA ***************/
	/***********************************************************/
	DecodeRetornoJSON("false", "Não foi possível identificar a ação a ser realizada.", "");
?>