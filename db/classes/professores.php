<?php 
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";

	class Professor {
		public $id;
		public $nome;
		public $cpf;
		public $prontuario;
		public $email;
		public $cargo;
		public $tipo;

		public function ConverterCargo(){
			// 0 - Professor | 1 - Palestrante | 2 - Técnico | 3 - Monitor | 4 - Administrativo
			switch (strtolower($this->cargo)) {
				case "cargo":
					$this->cargo = -1;
					break;

				case "palestrante":
					$this->cargo = 1;
					break;

				case "tecnico":
					$this->cargo = 2;
					break;

				case "monitor":
					$this->cargo = 3;
					break;

				case "administrativo":
					$this->cargo = 4;
					break;

				default:
					$this->cargo = 0;
					break;
			}
		}

		public function ConverterTipo(){
			// 0 - EBTT | 1 - Substutivo | 2 - Voluntário
			switch ($this->tipo) {
				case "substutivo":
					$this->tipo = 1;
					break;

				case "voluntario":
					$this->tipo = 2;
					break;

				default:
					$this->tipo = 0;
					break;
			}
		}

		public function Cadastrar(){
			if ($this->email) {
				if (!ValidarEmail($this->email)) {
					echo DecodeRetornoJSON("false", "Email inválido.", "");
					die();
				}
			}

			$this->ConverterCargo();
			$this->ConverterTipo();
			return Insert("professores", "'$this->nome', '$this->cpf', '$this->prontuario', '$this->email', $this->cargo, $this->tipo");
		}

		public function Editar() {
			$this->ConverterCargo();
			$this->ConverterTipo();

			$valores = array();
			$valores["nome"] 	   = "'" .$this->nome. "'";
			$valores["cpf"]  	   = "'" .$this->cpf. "'";
			$valores["prontuario"] = "'" .$this->prontuario. "'";
			$valores["email"] 	   = "'" .$this->email. "'";
			$valores["cargo"] 	   = $this->cargo;
			$valores["tipo"]	   = $this->tipo;

			return Update("professores", $valores, "id = $this->id");
		}

		public function Listar() {
			$condicao = "NOT excluido";

			if ($this->id){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao = "id = " .$this->id;
			}

			if ($this->nome){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "nome LIKE '%" .$this->nome. "%'";
			}

			if ($this->cpf){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "cpf = '" .$this->cpf. "'";
			}

			if ($this->prontuario){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "prontuario = '" .$this->email. "'";
			}	

			if ($this->cargo){
				$this->ConverterCargo();

				if ($this->cargo > -1){
					if ($condicao){
						$condicao .= " AND ";
					}

					$condicao .= "cargo = " .$this->cargo;
				}
			}

			return Get("professores", "id, nome, cpf, prontuario, cargo", $condicao);
		}

		public function Carregar(){
			return Get("professores", "id, nome, cpf, prontuario, email, cargo, tipo", "id = " .$this->id);
		}

		public function Excluir(){
			return Excluir("professores", "id = " .$this->id);
		}
	}
?>