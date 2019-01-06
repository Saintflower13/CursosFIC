<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";
	include_once "participantes.php";

	class Matricula {
		public $id;
		public $id_turma;
		public $participantes;

		public function Matricular() {
			$sql = "INSERT INTO matriculas (participante_id, turma_id, registro_numero, registro_pagina, registro_livro) VALUES ";

			for ($i = 0; $i < count($this->participantes); $i++) {
				$sql .= "(" .$this->participantes[$i]. "," .$this->id_turma. ",0,0,0)";

				if ($i < count($this->participantes) -1) {
					$sql .= ",";
				}
			}

			echo QueryPura($sql, "U");
		}

		public function Cancelar() {
			echo Cancelar("matriculas", "id = " .$this->id);
		}

		public function ListarParticipantes() {
			$sql  = "SELECT T1.id, T2.id AS id_participante, T2.nome, T2.numero_documento, T2.email ";
			$sql .= "FROM matriculas AS T1 INNER JOIN participantes AS T2 ON T2.id = T1.participante_id ";
			$sql .= "WHERE status = 0 AND NOT cancelado AND turma_id = $this->id_turma";

			echo QueryPura($sql, "R");
		}
	}
?>