<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";

	class Docente {
		public $id;
		public $id_professor;
		public $id_turma;
		public $carga_horaria;
		public $arr_docentes;

		public function Cadastrar(){
			$mensagem = "";
			$turma    = $this->id_turma;

			if ($turma < 1) {
				echo DecodeRetornoJSON("false", "Turma não identificada.", "");
				die();
			}

			foreach ($this->arr_docentes as $docente) {
				$retorno = Insert("docentes", "$docente->id_docente, $turma, $docente->carga_horaria");
				$retorno = json_decode($retorno, true);

				if (!$retorno["Status"]) {
					$mensagem .= $retorno["Mensagem"] ."\\n";
				}
			}

			if ($mensagem !== "") {
				return DecodeRetornoJSON("false", $mensagem, "");
				die();
			}

			return DecodeRetornoJSON("true", "", "");
		}

		public function Cancelar(){
			return Cancelar("docentes", "id = " .$this->id);
		}

		public function CarregarPorTurma(){
			$sql  = "SELECT T1.id, T2.id AS id_docente, T2.nome, T1.carga_horaria FROM docentes AS T1 ";
			$sql .= "INNER JOIN professores AS T2 ON T2.id = T1.docente_id ";
			$sql .= "WHERE NOT T1.cancelado AND T1.turma_id = $this->id_turma;";

			return QueryPura($sql, "R");
		}
	}

?>