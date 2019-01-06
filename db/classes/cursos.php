<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";
	include_once "professores.php";

	class Curso {
		public $id;
		public $titulo;
		public $tipo;
		public $descricao;
		public $campus;
		public $professor; // PARA SER USADO COMO OBJETO DA CLASSE PROFESSOR
		public $professor_id;
		public $ementa;

		function Validaripo() {
			return $this->tipo == "0" || $this->tipo == "1" || $this->tipo == "2" ? true : false;
		}

		function ValidarCampus() {
			return $this->campus == "0" || $this->campus == "1" ? true : false;
		}

		function ConverterTipo() {
			switch ($this->tipo) {
				case "curso":
					$this->tipo = "0";
					break;

				case "minicurso":
					$this->tipo = "1";
					break;

				case "palestra":
					$this->tipo = "2";
					break;

				default:
					$this->tipo = "-1";
					break;
			}
		}

		function Cadastrar() {
			return Insert("cursos", "'$this->titulo', '$this->descricao', '$this->ementa', $this->campus, $this->professor_id, $this->tipo");
		}

		public function Editar() {
			$valores = array();
			$valores["titulo"] 		 = "'" .$this->titulo. "'";
			$valores["descricao"]    = "'" .$this->descricao. "'";
			$valores["ementa"]		 = "'" .$this->ementa. "'";
			$valores["campus"] 		 = $this->campus;
			$valores["professor_id"] = $this->professor_id;
			$valores["tipo"] 		 = $this->tipo;

			return Update("cursos", $valores, "id = $this->id");
		}

		public function ListarProfessores() {
			$professor = new Professor();
			echo $professor->Listar();
		}

		public function Listar() {
			$condicao = "NOT cancelado";

			if ($this->id) {
				$condicao .= " AND T1.id = " .$this->id;
			}

			if ($this->titulo) {
				$condicao .= " AND titulo LIKE '%" .$this->titulo. "%'";	
			}

			if ($this->tipo) {
				$this->ConverterTipo();

				if ($this->tipo >= 0) {
					$condicao .= " AND T1.tipo = " .$this->tipo;
				}
			}

			if ($this->professor_id) {
				$condicao .= " AND professor_responsavel_id = " .$this->professor_id;
			}

			$sql  = "SELECT T1.id, T1.titulo, T1.tipo, T2.nome AS professor FROM cursos AS T1 ";
			$sql .= "INNER JOIN professores AS T2 ON T2.id = T1.professor_responsavel_id ";
			$sql .= "WHERE  " .$condicao. " LIMIT 50;";

			return QueryPura($sql, "R");	
		}

		public function Carregar(){
			$sql  = "SELECT T1.id, T1.titulo, T1.descricao, T1.ementa, T1.campus, T1.tipo, T2.nome AS professor ";
			$sql .= "FROM cursos AS T1 INNER JOIN professores AS T2 ON T2.id = T1.professor_responsavel_id ";
			$sql .= "WHERE T1.id = " .$this->id;

			return QueryPura($sql, "R");
		}

		public function Cancelar(){
			return Cancelar("cursos", "id = " .$this->id);
		}
	}
?>