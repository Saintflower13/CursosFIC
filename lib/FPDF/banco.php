<?php
	function GetTipoCurso($valor) {
		switch ($valor) {
			case "0":
				$tipo = 'Curso';
				break;
					
			case "1":
				$tipo = 'Mini Curso';
				break;

			case "2":
				$tipo = 'Palestra';
				break;

			default:
				$tipo = '';
				break;
		} 

		return $tipo; 		
	}

	function GetTipoDocumento($valor) {
		switch ($valor) {
			case "0":
				$tipo = 'CPF';
				break;
					
			case "1":
				$tipo = 'RG';
				break;

			case "2":
				$tipo = 'Certidao de Nascimento';
				break;

			default:
				$tipo = '';
				break;
		}

		return $tipo;
	}

	function GetTurma($id) {
		include('conexao.php');

		$query = "SELECT T2.titulo, T2.tipo, T3.nome AS professor, T1.data_inicio, T1.data_fim, T1.carga_horaria, T2.ementa FROM turmas AS T1 INNER JOIN cursos AS T2 ON T2.id = T1.curso_id INNER JOIN professores AS T3 ON T3.id = T2.professor_responsavel_id WHERE T1.id = $id";

		$resultado = mysqli_query($conexao, $query);
		$turma     = array();

		if (mysqli_num_rows($resultado) > 0) {
			while($linha = mysqli_fetch_assoc($resultado)) {
				$turma[] = array(
					'Titulo'        => $linha['titulo'],
					'Tipo'          => GetTipoCurso($linha['tipo']),
					'Professor'     => $linha['professor'],
					'data_inicio'   => $linha['data_inicio'],
					'data_fim'      => $linha['data_fim'],
					'carga_horaria' => $linha['carga_horaria'],
					'ementa'        => $linha['ementa']
				); 
			}

			return $turma;
		} else {
		   	echo "[]";
		}
	}


	function GetParticipantes($ids_participantes) {
		include('conexao.php');

		$query = "SELECT T2.nome,  T2.numero_doc, T2.tipo_doc, T1.registro_numero, T1.registro_pagina, T1.registro_livro FROM matriculas AS T1 INNER JOIN participantes AS T2 ON T2.id = T1.participante_id WHERE T1.participante_id IN ($ids_participantes)";

		$resultado     = mysqli_query($conexao, $query);
		$participantes = array();

		if (mysqli_num_rows($resultado) > 0) {
			while($linha = mysqli_fetch_assoc($resultado)) {
				$participantes[] = [
					'Nome'            => $linha['nome'],
					'tipo_doc'        => GetTipoDocumento($linha['tipo_doc']),
					'numero_doc' 	  => $linha['numero_doc'],
					'registro_numero' => $linha['registro_numero'], 
					'registro_pagina' => $linha['registro_pagina'],
					'registro_livro'  => $linha['registro_livro']
				];
			}

			return $participantes;
		} else {
		   	echo "[]";
		}
	}

?>