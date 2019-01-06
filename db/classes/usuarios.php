<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";

	class Usuario {
		public $id;
		public $usuario;
		public $senha;
		public $senha_confirmar;

		public function ValidarSenha(){
			return $this->senha === $this->senha_confirmar;
		}

		public function Cadastrar(){
			if (!$this->ValidarSenha()) {
				echo DecodeRetornoJSON("false", "As senhas informadas não são iguais.", "");
				die();
			}

			return Insert("usuarios", "'$this->usuario', '" .md5($this->senha). "'");
		}

		public function Editar(){
			if (!$this->ValidarSenha()) {
				return DecodeRetornoJSON("false", "As senhas informadas não são iguais.", "");
				die();
			}

			$valores = array();
			$valores["usuario"] = "'" .$this->usuario. "'";
			$valores["senha"]   = "'" .md5($this->senha). "'";

			return Update("usuarios", $valores, "id = $this->id");
		}

		public function Carregar(){
			return Get("usuarios", "id, usuario", "id = " .$this->id);
		}

		public function Excluir(){
			return Excluir("usuarios", "id = " .$this->id);
		}

		public function Listar(){
			$condicao = "NOT excluido";

			if ($this->usuario) {
				$condicao .= " AND usuario LIKE '%$this->usuario%'";
			}

			return Get("usuarios", "id, usuario", $condicao);
		}
	}
?>