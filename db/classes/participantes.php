<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";

	class Participante {
		public $id;
		public $nome;
		public $tipo_documento;
		public $numero_documento;
		public $email;

		public function ConverterTipoDocumento() {
			// 0 - CPF | 1 - RG | 2 - CERTIDÃO DE NASCIMENTO
			switch ($this->tipo_documento) {
				case "rg":
					$this->tipo_documento = 1;
					break;

				case "nasc":
					$this->tipo_documento = 2;
					break;

				default:
					$this->tipo_documento = 0;
					break;
			}
		}

		public function Cadastrar() {
			if ($this->email) {
				if (!ValidarEmail($this->email)) {
					echo DecodeRetornoJSON("false", "Email inválido.", "");
					die();
				}
			}

			$this->ConverterTipoDocumento();
			return Insert("participantes", "'$this->nome', $this->tipo_documento, '$this->numero_documento', '$this->email'");
		}

		public function Editar() {
			$this->ConverterTipoDocumento();

			$valores = array();
			$valores["nome"] 			 = "'" .$this->nome. "'";
			$valores["tipo_documento"]   = $this->tipo_documento;
			$valores["numero_documento"] = "'" .$this->numero_documento. "'";
			$valores["email"] 			 = "'" .$this->email. "'";

			return Update("participantes", $valores, "id = $this->id");
		}

		public function Listar() {
			$condicao = "NOT excluido";

			if ($this->id){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "id = " .$this->id;
			}

			if ($this->nome){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "nome LIKE '%" .$this->nome. "%'";
			}

			if ($this->numero_documento){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "numero_documento = '" .$this->numero_documento. "'";
			}

			if ($this->email){
				if ($condicao){
					$condicao .= " AND ";
				}

				$condicao .= "email LIKE '%" .$this->email. "%'";
			}	

			return Get("participantes", "id, nome, numero_documento, email", $condicao);
		}

		public function Carregar(){
			return Get("participantes", "id, nome, tipo_documento, numero_documento, email", "id = " .$this->id);
		}

		public function Excluir(){
			return Excluir("participantes", "id = " .$this->id);
		}
	}

?>