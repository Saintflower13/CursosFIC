<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";
	include_once "../base/enviar_emails.php";
	include_once "../certificados/gerar.php";

	class Certificado {
		public $ids_participantes;
		public $participantes;
		public $professores;
		public $id_turma;
		public $turma;
		public $caminho;

		private $email_assunto = "Certificado IFSP-CJO";
		private $email_corpo   = "Parabéns, toma seu certificado!";


		public function Deletar() {
			if (file_exists($this->caminho)) {
				unlink($this->caminho);
			}
		}

		public function GerarParticipantesCertificados() {
			/* CARREGA OS DADOS NECESSÁRIOS DA TURMA E PARTICIPANTES,
			   GERA OS PDFS DOS PARTICIPANTES INFORMADOS E RETORNA O CAMINHO ONDE FOI
			   SALVO O CERTIFICADO PARA SER EXIDO NO ARQUIVO JQUERY CORRESPONDENTE */
			$this->CarregarDadosTurma();
			$this->CarregarParticipantes();

			echo GerarCertificadoParticipante($this->turma, $this->participantes, "");
		}

		public function EnviarCertificados() {
			$this->CarregarDadosTurma();
			$this->CarregarParticipantes();

			$erros = "";

			foreach ($this->participantes as $participante) {
				$participantes   = array();
				$participantes[] = $participante;

				$caminho = GerarCertificadoParticipante($this->turma, $participantes, "I");
				$anexos  = $this->GerarCertificadoAnexo($caminho, $this->turma[0]["titulo"]);

				$retorno = EnviarEmail($participante["email"], $this->email_assunto, $this->email_corpo, $anexos);
				$retorno = json_decode($retorno);

				if (!$retorno->Status) {
					$erros .= $participante["nome"]. " (" .$participante["email"]. ") - Erro:" .$retorno->Mensagem. " <br>";
				}

				$this->Deletar($caminho);
			}

			if ($erros == "") {
				return DecodeRetornoJSON("true", "", "");
			} else {
				return DecodeRetornoJSON("false", $erros, "");
			}
		}

		function GerarCertificadoAnexo($caminho, $curso) {
			$anexos = array();
			$anexo  = array();

			if ($caminho !== "") {
				$anexo["nome"]    = $curso;
				$anexo["caminho"] = $caminho;
			}

			$anexos[] = $anexo;	
			return $anexos;
		}

		public function CarregarParticipantes() {
			$sql  = "SELECT T1.nome, T1.tipo_documento, T1.numero_documento, T2.registro_livro, T2.registro_pagina, T2.registro_numero, T1.email ";
			$sql .= "FROM participantes AS T1 INNER JOIN matriculas AS T2 ON T2.participante_id = T1.id AND NOT T2.cancelado ";
			$sql .= "WHERE T2.id IN ($this->ids_participantes);";

			$retorno = json_decode(QueryPura($sql, "R"), true);

			if (!$retorno || !$retorno["Status"]) {
				return false;
				die();
			}

			$this->participantes = $retorno["Dados"];
		}

		public function CarregarDadosTurma() {
			$sql  = "SELECT T1.titulo, T1.tipo, T3.nome AS professor, T2.data_inicio, T2.data_fim, T2.carga_horaria, T1.ementa ";
			$sql .= "FROM cursos AS T1 INNER JOIN turmas AS T2 ON T2.curso_id = T1.id ";
			$sql .= "INNER JOIN professores AS T3 ON T3.id = T1.professor_responsavel_id ";
			$sql .= "WHERE T2.id = $this->id_turma;";

			$retorno = json_decode(QueryPura($sql, "R"), true);

			if (!$retorno || !$retorno["Status"]) {
				return false;
				die();
			}

			$this->turma = $retorno["Dados"];
		}
	}
?>