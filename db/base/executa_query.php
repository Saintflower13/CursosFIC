<?php
	require_once "conexao.php";
	require_once "tipos.php";
	include_once "funcoes_uteis.php";

	/** 
		FUNÇÃO QUE EXECUTA A SQL PASSADA POR PARAMETRO E 
		RETORNA UM ARRAY ASSOCIATIVO DOS CAMPOS INFORMADOS 
		BASEADO NA VARIÁVEL $TIPO, QUE DEVE RECEBER UM DOS 
		SEGUINTES VALORES: 
		"R" - RETORNA VALOR DO BANCO (SELECT) OU
		"I" - INSERE VALOR NO BANCO (INSERT, UPDATE)
	**/
	function QueryPura($sql, $tipo) {
		global $conexao;

		$retorno = mysqli_query($conexao, $sql);
		$erro    = mysqli_error($conexao);

		if ($erro) {
			// GERA E RETORNA JSON DE ERRO
			return DecodeRetornoJSON("false", $erro, "");
			die();
		}

		switch ($tipo) {
			// RETORNA VALOR DO BANCO
			case "R": 
				$resultado = array(); 

				if ($retorno) {
					while($registro  = mysqli_fetch_assoc($retorno)) {
						$resultado[] = $registro;
					}
				}

				return DecodeRetornoJSON("true", "", json_encode($resultado));
				break;
			
			// INSERE VALOR NO BANCO
			case "I":
				$id_inserido = mysqli_insert_id($conexao);

				return DecodeRetornoJSON("true", "", json_encode($id_inserido));
				break;

			// ALTERA VALOR NO BANCO
			case "U":
				$id_inserido = mysqli_insert_id($conexao);

				return DecodeRetornoJSON("true", "", json_encode(($retorno ? "true" : "false")));
				break;

			// PARAMETRO INVÁLIDO
			default:
				return DecodeRetornoJSON("false", "Parametro inválido", "");
				break;
		}
	}

	function Insert($tabela, $campos_valores) {
		switch ($tabela) {
			case "participantes":
				$campos = "(nome, tipo_documento, numero_documento, email)";
				break;
			
			case "professores":
				$campos = "(nome, cpf, prontuario, email, cargo, tipo)";
				break;

			case "turmas":
				$campos = "(curso_id, descricao, data_inicio, data_fim, carga_horaria, horario_inicial, horario_final, semestre, ano)";
				break;

			case "turmas_dias":
				$campos = "(turma_id, domingo, segunda, terca, quarta, quinta, sexta, sabado)";
				break;

			case "cursos":
				$campos = "(titulo, descricao, ementa, campus, professor_responsavel_id, tipo)";
				break;

			case "docentes":
				$campos = "(docente_id, turma_id, carga_horaria)";
				break;

			case "matriculas":
				$campos = "(participante_id, turma_id, registro_numero, registro_pagina, registro_livro)";
				break;

			case "usuarios":
				$campos = "(usuario, senha)";
				break;

			default:
				$campo = "tabela nao encontrada";
				break;
		}	
		$sql = "INSERT INTO " .$tabela. " " .$campos. " VALUES (" .$campos_valores. ");";
		return QueryPura($sql, "I");
	}

	function Update($tabela, $campos_valores, $condicao) {
		$retorno = false;
		$sql     = "UPDATE " .$tabela. " SET ";

		switch ($tabela) {
			case "participantes":
				$sql .= "nome = " .$campos_valores["nome"]. ", numero_documento = " .$campos_valores["numero_documento"]. ", tipo_documento = " .$campos_valores["tipo_documento"]. ", email = " .$campos_valores["email"];
				break;
			
			case "professores":
				$sql .= "nome = " .$campos_valores["nome"]. ", cpf = " .$campos_valores["cpf"]. ", prontuario = " .$campos_valores["prontuario"]. ", email = " .$campos_valores["email"]. ", cargo = " .$campos_valores["cargo"]. ", tipo = " .$campos_valores["tipo"];
				break;

			case "turmas":
				$sql .=  "curso_id = " .$campos_valores["curso_id"]. ", descricao = " .$campos_valores["descricao"]. ", data_inicio = " .$campos_valores["data_inicio"]. ", data_fim = " .$campos_valores["data_fim"]. ", carga_horaria = " .$campos_valores["carga_horaria"]. ", horario_inicial = " .$campos_valores["horario_inicial"]. ", horario_final = " .$campos_valores["horario_final"]. ", semestre = " .$campos_valores["semestre"]. ", ano = " .$campos_valores["ano"];
				break;

			case "turmas_dias":
				$sql .= "domingo = " .$campos_valores["domingo"]. ", segunda = " .$campos_valores["segunda"]. ", terca = " .$campos_valores["terca"]. ", quarta = " .$campos_valores["quarta"]. ", quinta = " .$campos_valores["quinta"]. ", sexta = " .$campos_valores["sexta"]. ", sabado = " .$campos_valores["sabado"];
				break;

			case "cursos":
				$sql .= "titulo = " .$campos_valores["titulo"]. ", descricao = " .$campos_valores["descricao"]. ", ementa = " .$campos_valores["ementa"]. ", campus = " .$campos_valores["campus"]. ", professor_responsavel_id = " .$campos_valores["professor_id"]. ", tipo = " .$campos_valores["tipo"];
				break;


			case "docentes":
				$sql .= "docente_id = " .$campos_valores["docente_id"]. ", turma_id = " .$campos_valores["turma_id"]. ", carga_horaria = " .$campos_valores["carga_horaria"];
				break;

			case "matriculas":
				$sql .= "participante_id = " .$campos_valores[0]["participante_id"]. ", turma_id = " .$campos_valores[0]["turma_id"]. ", registro_numero = " .$campos_valores[0]["registro_numero"]. ", registro_pagina = " .$campos_valores[0]["registro_pagina"]. ", registro_livro = " .$campos_valores[0]["registro_livro"];
				break;

			case "usuarios":
				$sql .= "usuario = " .$campos_valores["usuario"]. ", senha = " .$campos_valores["senha"];
				break;

			default:
				$sql = "";
				break;
		}

		if ($sql !== "") {
			$sql .= " WHERE " .$condicao;
			$retorno = QueryPura($sql, "U");
		}

		return $retorno;
	}

	function SetEmailEnviado($ids) {
		$sql = "UPDATE matriculas SET email_enviado = true WHERE id IN (" .$ids. ");";
		return QueryPura($sql, "U");
	}

	function SetCursoCompleto($ids) {
		$sql = "UPDATE matriculas SET status = true WHERE id IN (" .$ids. ");";
		return QueryPura($sql, "U");
	}

	// PEGA VALORES DO BANCO
	function Get($tabela, $campos, $condicao) {
		$sql = "SELECT " .$campos. " FROM " .$tabela;

		if ($condicao) {
			$sql .= " WHERE " .$condicao;	
		}

		$sql .= " LIMIT 50;";

		return QueryPura($sql, "R");
	}

	// CANCELA REGISTROS DE TABELAS QUE POSSUEM A COLUNA CANCELADO
	function Cancelar($tabela, $condicao) {
		$sql   = "UPDATE " .$tabela. " SET cancelado = true WHERE " .$condicao;
		return QueryPura($sql, "U");
	}

	// CANCELA REGISTROS DE TABELAS QUE POSSUEM A COLUNA EXCLUIDO
	function Excluir($tabela, $condicao) {
		$sql   = "UPDATE " .$tabela. " SET excluido = true WHERE " .$condicao;
		return QueryPura($sql, "U");
	}

	function GetTurma($id) {
		$sql = "SELECT T2.titulo, T2.tipo, T3.nome AS professor, T1.data_inicio, T1.data_fim, T1.carga_horaria, T2.ementa FROM turmas AS T1 INNER JOIN cursos AS T2 ON T2.id = T1.curso_id INNER JOIN professores AS T3 ON T3.id = T2.professor_responsavel_id WHERE T1.id = " .$id. ";";

		$retorno = QueryPura($sql, "R");

		for ($i = 0; $i < Count($retorno); $i++) {
			$retorno[$i]["tipo"] = GetTipoCurso($retorno[$i]["tipo"]);
		}

		return $retorno;
	}

	function GetParticipantes($ids_participantes) {
		$sql = "SELECT T2.nome,  T2.numero_docomento, T2.tipo_documento, T1.registro_numero, T1.registro_pagina, T1.registro_livro FROM matriculas AS T1 INNER JOIN participantes AS T2 ON T2.id = T1.participante_id WHERE T1.participante_id IN (" .$ids_participantes. ") AND NOT T1.cancelado AND NOT T1.status;";

		$retorno = QueryPura($sql, "R");

		for ($i = 0; $i < Count($retorno); $i++) {
			$retorno[$i]["tipo_doc"] = GetTipoDocumento($retorno[$i]["tipo_doc"]);
		}

		return $retorno;
	}
?>