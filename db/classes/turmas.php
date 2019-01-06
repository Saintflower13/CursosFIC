<?php
	include_once "../base/executa_query.php";
	include_once "../base/funcoes_uteis.php";
	include_once "cursos.php";
	include_once "docentes.php";

	class Turma {
		public $id;
		public $id_curso;
		public $descricao;
		public $semestre;
		public $ano;
		public $data_inicio;
		public $data_fim;
		public $carga_horaria;
		public $horario_inicial;
		public $horario_final;
		public $id_dias; // ID DA TABELA TURMAS_DIAS
		public $dias;

		public $cursos;     
		public $professores;
		public $docentes;

		public function ValidarCampos() {
			// CAMPOS OBRIGATÓRIOS
			if ($this->id_curso === "" || $this->semestre === "" || $this->ano === "") {
				return "Os campos Curso, Semestre e Ano são obrigatórios.";
			}

			if ($this->semestre == "0") {
				return "Informe um semestre para o cadastro.";
			}

			if ($this->ano < 2000) {
				return "Ano informado é inválido.";
			}

			if ($this->id_curso == "0") {
				return "Informe um curso para o cadastro.";
			}

			if ($this->data_inicio == "") {
				$data_inicio = "00/00/0000 00:00:00";
			}

			if ($this->data_fim == "") {
				$data_fim = "00/00/0000 00:00:00";
			}

			if ($this->carga_horaria == "") {
				$this->carga_horaria = 0;
			}

			if ($this->horario_inicial == "") {
				$this->horario_inicial = "00:00";
			}

			if ($this->horario_final == "") {
				$this->horario_final = "00:00";
			}

			return "";
		}

		// CADASTRA A TURMA. SE O CADASTRO FOR BEM SUCEDIDO, SÃO CADASTRADOS OS DIAS E OS DOCENTES EM SEGUIDA
		public function Cadastrar() {
			$retorno  = Insert("turmas", "$this->id_curso, '$this->descricao', '$this->data_inicio', '$this->data_fim', $this->carga_horaria, '$this->horario_inicial', '$this->horario_final', $this->semestre, '$this->ano'");

			$retorno  = json_decode($retorno, true);
		
			if (!$retorno["Status"]) {
				echo DecodeRetornoJSON("false", $retorno["Mensagem"], "");
				die();
			}		

			$this->id = $retorno["Dados"]; // ID DA TURMA CADASTRADA

			// CADASTRAR DIAS
			$mensagem = $this->CadastrarDias();	

			if ($mensagem !== "") {
				echo DecodeRetornoJSON("false", $mensagem, "");
				die();
			}

			// CADASTRAR DOCENTES
			if ($this->docentes->arr_docentes) {
				$mensagem = $this->CadastrarDocentes();	

				if ($mensagem !== "") {
					echo DecodeRetornoJSON("false", $mensagem, "");
					die();
				}	
			}

			return DecodeRetornoJSON("true", "", "");
		}

		public function Editar() {
			$valores 				    = array();
			$valores["curso_id"] 	    = $this->id_curso;
			$valores["descricao"]       = "'" .$this->descricao. "'";
			$valores["data_inicio"]	    = "'" .$this->data_inicio. "'";
			$valores["data_fim"] 	    = "'" .$this->data_fim. "'";
			$valores["carga_horaria"]   = $this->carga_horaria;
			$valores["horario_inicial"] = "'" .$this->horario_inicial. "'";
			$valores["horario_final"]   = "'" .$this->horario_final. "'";
			$valores["semestre"]        = $this->semestre;
			$valores["ano"] 		    = "'" .$this->ano. "'";

			// UPDATE DAS INFORMAÇÕES BÁSICAS DA TURMA
			$retorno = Update("turmas", $valores, "id = $this->id");
			$retorno = json_decode($retorno, true);
		
			// VERIFICA SE FOI BEM SUCESSIDA A ATUALIZAÇÃO
			if (!$retorno["Status"]) {
				echo DecodeRetornoJSON("false", $retorno["Mensagem"], "");
				die();
			}		

			// EDITAR DIAS
			$mensagem = $this->EditarDias();	

			// VERIFICA ATUALIZAÇÃO DOS DIAS
			if ($mensagem !== "") {
				echo DecodeRetornoJSON("false", $mensagem, "");
				die();
			}

			// CADASTRAR DOCENTES NOVOS INSERIDOS
			if ($this->docentes->arr_docentes) {
				$mensagem = $this->CadastrarDocentes();	

				if ($mensagem !== "") {
					echo DecodeRetornoJSON("false", $mensagem, "");
					die();
				}	
			}

			return DecodeRetornoJSON("true", "", "");
		}

		// CADASTRA OS DIAS INFORMADOS. SE RESULTADO OK, RETORNA STRING VAZIA,
		// CASO CONTRÁRIO, RETORNA A STRING COM O ERRO
		public function CadastrarDias() {
			$this->dias = json_decode($this->dias);

			// 0 - DOMINGO | 6 - SÁBADO
			$valores = $this->id;
			foreach ($this->dias as $dia) {
				$valores .= "," .$dia;
			}

			$retorno = Insert("turmas_dias", $valores);
			$retorno = json_decode($retorno, true);

			if (!$retorno["Status"]) {
				return $retorno["Mensagem"];
				die();
			}

			return "";
		}

		// FAZ UM UPDATE DOS DIAS INFORMADOS. SE RESULTADO OK, RETORNA STRING VAZIA,
		// CASO CONTRÁRIO, RETORNA A STRING COM O ERRO
		public function EditarDias() {
			$this->dias = json_decode($this->dias);

			// 0 - DOMINGO | 6 - SÁBADO
			$valores    	    = array();
			$valores["domingo"] = $this->dias[0];
			$valores["segunda"] = $this->dias[1];
			$valores["terca"]   = $this->dias[2];
			$valores["quarta"]  = $this->dias[3];
			$valores["quinta"]  = $this->dias[4];
			$valores["sexta"]   = $this->dias[5];
			$valores["sabado"]  = $this->dias[6];

			$retorno = Update("turmas_dias", $valores, "id = " .$this->id_dias);
			$retorno = json_decode($retorno, true);

			if (!$retorno["Status"]) {
				return $retorno["Mensagem"];
				die();
			}

			return "";
		}

		// CADASTRA O(S) DOCENTE(S. SE O CADASTRO FOR BEM SUCEDIDO É RETORNADA UMA STRING VAZIA
		// CASO CONTRÁRIO, O ERRO É RETORNADO
		public function CadastrarDocentes() {
			$this->docentes->arr_docentes = json_decode($this->docentes->arr_docentes);

			if (count($this->docentes->arr_docentes) > 0) {
				$docentes 				= new Docente();
				$docentes->id_turma     = $this->id; 
				$docentes->arr_docentes = $this->docentes->arr_docentes; // ARRAY COM AS INFORMAÇÕES DO(S) DOCENTE(S)
				$retorno 		        = $docentes->Cadastrar();

				$retorno  				= json_decode($retorno, true);

				if (!$retorno["Status"]) {
					return $retorno["Mensagem"];
					die();
				}
			}

			return "";
		}

		public function CancelarDocente() {
			$this->docentes     = new Docente();
			$this->docentes->id = $this->id;
			return $this->docentes->Cancelar();
		}

		public function Cancelar() {
			return Cancelar("turmas", "id = " .$this->id);
		}

		public function Listar() {
			$condicao = "NOT T1.cancelado";

			if ($this->id) {
				$condicao .= " AND T1.id = " .$this->id;
			}

			if ($this->id_curso) {
				$condicao .= " AND T1.curso_id = " .$this->id_curso;
			}

			if ($this->semestre) {
				$condicao .= " AND T1.semestre = " .$this->semestre;
			}

			if ($this->ano) {
				$condicao .= " AND T1.ano LIKE '%" .$this->ano. "%'";
			}

			if ($this->descricao) {
				$condicao .= " AND T1.descricao LIKE '%" .$this->descricao. "%'";
			}

			$sql  = "SELECT T1.id, T2.titulo, T1.semestre, T1.ano, T1.descricao, T1.horario_inicial, T1.horario_final, ";
			$sql .= "T3.domingo, T3.segunda, T3.terca, T3.quarta, T3.quinta, T3.sexta, T3.sabado ";
			$sql .= "FROM turmas AS T1 INNER JOIN cursos AS T2 ON T2.id = T1.curso_id ";
			$sql .= "LEFT JOIN turmas_dias AS T3 ON T3.turma_id = T1.id ";
			$sql .= "WHERE " .$condicao. " ";
			$sql .= "LIMIT 100";

			return QueryPura($sql, "R");
		}

		public function ListarCursos() {
			$this->cursos = new Curso;
			return $this->cursos->Listar();
		}

		public function ListarProfessores() {
			$this->professores = new Professor;
			return $this->professores->Listar();
		}

		public function CarregarDocentes() {
			$this->docentes = new Docente();
			return $this->docentes->Carregar();
		}

		public function Carregar() {
			$msg_erro       = "Não foi possível carregar os dados da turma.";

			// OBTÊM OS DADOS PRINCIPAIS DA TURMA E RETORNA NO FORMATO PADRÃO,
			// EM SEGUIDA, VERIFICA SE O RETORNO É VÁLIDO
			$dados_turma    = $this->ObterDados();

			if (!$dados_turma["Status"]) {
				return DecodeRetornoJSON("false", $msg_erro, "");
				die();
			}

			// OBTÊM OS DADOS DE DOCENTES VINCULADOS À TURMA E VALIDA O RETORNO EM SEGUIDA
			$dados_docentes = $this->ObterDocentes();

			if (!$dados_docentes["Status"]) {
				return DecodeRetornoJSON("false", $msg_erro, "");
				die();
			}

			// PEGA OS DADOS RELEVANTES RETORNADOS SE TUDO DEU CERTO
			$dados_turma 	= $dados_turma["Dados"];
			$dados_docentes = $dados_docentes["Dados"];

			$retorno        = $this->GerarJSONTurma($dados_turma, $dados_docentes);
			return DecodeRetornoJSON("true", "", $retorno);
		}

		public function ObterDados() {
			$sql  = "SELECT T1.id, T2.titulo, T1.descricao, T1.data_inicio, T1.data_fim, ";
			$sql .= "T1.carga_horaria, T1.horario_inicial, T1.horario_final, T1.semestre, T1.ano, T3.domingo, T3.segunda, ";
			$sql .= "T3.terca, T3.quarta, T3.quinta, T3.sexta, T3.sabado, T3.id AS id_dias ";
			$sql .= "FROM turmas AS T1 INNER JOIN cursos AS T2 ON T2.id = T1.curso_id ";
			$sql .= "LEFT JOIN turmas_dias AS T3 ON T3.turma_id = T1.id ";
			$sql .= "WHERE T1.id = $this->id;";

			$dados_turma = QueryPura($sql, "R");	
			return json_decode($dados_turma, true);		 
		}

		public function ObterDocentes() {
			$this->docentes 		  = new Docente();
			$this->docentes->id_turma = $this->id; 
			$dados_docentes 		  = $this->docentes->CarregarPorTurma();
			return	  		  	      json_decode($dados_docentes, true);
		}

		public function GerarJSONTurma($dados_turma, $dados_docentes) {
			// INFORMAÇÕES BÁSICAS DA TURMA
			$id_turma        = $dados_turma[0]["id"];
			$titulo          = $dados_turma[0]["titulo"];
			$descricao       = $dados_turma[0]["descricao"];
			$data_inicio     = $dados_turma[0]["data_inicio"];
			$data_fim        = $dados_turma[0]["data_fim"];
			$horario_inicial = $dados_turma[0]["horario_inicial"];
			$horario_final   = $dados_turma[0]["horario_final"];
			$carga_horaria   = $dados_turma[0]["carga_horaria"];
			$semestre        = $dados_turma[0]["semestre"];
			$ano 		     = $dados_turma[0]["ano"];
			$id_dias 		 = $dados_turma[0]["id_dias"];

			// DIAS EM QUE OCORREM AS AULAS
			$dias  = $dados_turma[0]["domingo"]. ",";
			$dias .= $dados_turma[0]["segunda"]. ",";
			$dias .= $dados_turma[0]["terca"]  . ",";
			$dias .= $dados_turma[0]["quarta"] . ",";
			$dias .= $dados_turma[0]["quinta"] . ",";
			$dias .= $dados_turma[0]["sexta"]  . ",";
			$dias .= $dados_turma[0]["sabado"];


			// DOCENTES CADASTRADOS
			$docentes = "[";

			if (count($dados_docentes) > 0) {
				foreach ($dados_docentes as $docente) {
					$id 		= $docente["id"];
					$id_docente = $docente["id_docente"];
					$nome 		= $docente["nome"];
					$carga      = $docente["carga_horaria"];

					$docente  = '{"id": ' 			.$id. 		  ',';
					$docente .= '"id_docente": ' 	.$id_docente. ',';
					$docente .= '"nome": "'			.$nome. 	  '",';
					$docente .= '"carga_horaria": ' .$carga.      '},';

					$docentes .= $docente;
				}

				$docentes = mb_substr($docentes, 0, strlen($docentes) -1);
			}

			$docentes .= ']';

			// GERANDO O JSON DE RETORNO
			$retorno  = '{"id":'      	       .$id_turma.	      ',' . 
						' "titulo":"' 	       .$titulo. 		  '",'.
						' "descricao":"'       .$descricao.       '",'. 
						' "data_inicio":"'     .$data_inicio.     '",'. 
						' "data_fim":"'        .$data_fim. 	      '",'. 
						' "carga_horaria":'    .$carga_horaria.   ',' .
						' "horario_inicial":"' .$horario_inicial. '",'. 
						' "horario_final":"'   .$horario_final.   '",'. 
						' "semestre":'		   .$semestre. 	      ',' . 
						' "ano":'			   .$ano.			  ',' .
						' "id_dias":'		   .$id_dias.		  ',';

			$retorno .= '"Dias": [' .$dias. '], "Docentes":' .$docentes. '}';

			return json_encode($retorno);
		}
	}
?>