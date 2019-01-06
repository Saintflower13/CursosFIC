$(function(){
	CarregarCursos();
	CarregarProfessores();
	PreencherAno();

	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function PreencherCursos(select, dados){
		PreencherSelect(select, dados, "titulo", "id");
	}

	function PreencherProfessores(select, dados){
		PreencherSelect(select, dados, "nome", "id");
	}

	function GetNomeDocente(id_docente){
		return PegarInformacaoSimples("professores", "nome",  "id = " + id_docente, "...");
	}

	function PreencherAno(){
		var ano = new Date();
		$("#c_ano").val(ano.getFullYear());
	}

	function GerarStrDias(){
		var dias = [];

		$("input[type=checkbox]").each(function() {
			var status = this.checked ? "1" : "0";
			dias.push(status);
		});

		return dias;
	}

	function AdicionarHeaderDocentes(){
		$("#docentes_cadastrados").html(
			"<tbody>"							  +
			"<tr>"								  +
				"<th> ID </th>"  				  +
				"<th> Docentes Cadastrados </th>" +
				"<th> Carga Horária </th>" 		  +
				"<th> </th>" 					  +
			"</tr>"
		);	
	}

	function LimparCamposCadastros(){
		$("#c_id").val("");
		$("#c_descricao").val("");
		$("#c_carga_horaria").val("");
		$("#c_horario").val("");
		$("#c_data_inicial").val("");
		$("#c_data_final").val("");
		$("#c_horario").val("");
		PreencherAno();

		$("#curso_inicial").prop("selected", true);
		$("#sem_inicial").prop("selected", true);

		$("#c_dias_domingo").prop("checked", false);
		$("#c_dias_segunda").prop("checked", false);
		$("#c_dias_terca").prop("checked", false);
		$("#c_dias_quarta").prop("checked", false);
		$("#c_dias_quinta").prop("checked", false);
		$("#c_dias_sexta").prop("checked", false);
		$("#c_dias_sabado").prop("checked", false);
	}

	function LimparFiltrosDocentes(limpar_tabela){
		$("#docente_titulo").prop("selected", true);
		$("#c_docente_carga_horaria").val("");

		if (limpar_tabela) {
			SetarTabelaMensagem("#docentes_cadastrados", "Nenhum registro para exibir, no momento :)");
		}
	}

	function LimparFiltros(limpar_tabela){
		$("#p_id").val("");
		$("#p_ano").val("");
		$("#p_descricao").val("");

		$("#p_curso_inicial").prop("selected", true);
		$("#p_sem_inicial").prop("selected", true);

		if (limpar_tabela) {
			SetarTabelaMensagem("#resultado_turmas", "Nenhum registro para exibir, no momento :)");
		}	
	}

	// ADICIONA NA TABELA HTML DE DOCENTES AQUELES QUE JÁ FORAM CADASTRADOS
	// E RETORNADOS PELA FUNÇÃO DE CARREGAR TURMA
	function AdicionarDocentesCadastrados(docentes){
		AdicionarHeaderDocentes();

		$.each(docentes, function(i, docente){
			$("#docentes_cadastrados").append(
				"<tr id='" + docente.id + "'>" +
					"<td class='id_docente' id='" + docente.id_docente    + "'>" + PadLeft(docente.id_docente, 4) + "</td>" +
					"<td>" 				 		  + docente.nome 		  + "</td>" +
					"<td class='carga'>" 		  + docente.carga_horaria + "</td>" +
					"<td><span class='excluir-docente glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);

			$("#docentes_cadastrados").append("</tbody>");
		});
	}

	// ADICIONA DOCENTES NA TABELA HTML SEM CADASTRÁ-LOS NO BANCO
	function AdicionarDocentes(){
		var id_docente    = $("#c_docentes").val();
		var carga_horaria = $("#c_docente_carga_horaria").val();

		if (id_docente == "0" || carga_horaria == "0" || carga_horaria == "") {
			return;
		}

		var estado_tabela = $("#docentes_cadastrados").children('tbody').children('tr:first').attr("class");

		if (estado_tabela == "tabela-nenhum-registro") {
			AdicionarHeaderDocentes();
		}

		// ID DA TR GUARDA O ID (AH VÁ) DA TABELA DO BANCO, QUANDO FOR DOCENTE CARREGADO
		// ID DA COLUNA DOCENTE GUARDA O ID DO PROFESSOR
		$("#docentes_cadastrados").append(
			"<tr>" 		   			 		  +
				"<td class='id_docente' id='" + id_docente + "'>" + PadLeft(id_docente, 4) 	    + "</td>" +
				"<td>" 				 		  + GetNomeDocente(id_docente) 				   	    + "</td>" +
				"<td class='carga'>" 		  + carga_horaria 							  	    + "</td>" +
				"<td><span class='excluir-docente glyphicon glyphicon-remove color-darkred'></span></td>" +
			"</tr>"
		);

		$("#docentes_cadastrados").append("</tbody>");
		LimparFiltrosDocentes(false);
	}

	// GERA UM ARRAY COM AS INFORMAÇÕES DOS DOCENTES PARA SEREM ENVIADOS PARA
	// O PHP DE CADASTRO/ALTERAÇÃO
	function GerarArrayDocentes(){
		var docentes = [];

		$("#docentes_cadastrados > tbody  > tr").each(function(){
			var id = $(this).attr("id");
			id 	   = id ? id : 0; // ID DO DOCENTE QUE JÁ ESTÁ VINCULADO À TURMA

			var id_docente    = $(this).children('td:first').attr("id");
			var carga_horaria = $(this).find(".carga").text();


			if (!id_docente || !carga_horaria || id > 0) {
				return true;
			}

			var docente = {};

			docente["id"]            = id;
			docente["id_docente"]    = id_docente;
			docente["carga_horaria"] = carga_horaria;

			docentes.push(docente);
		});

		return docentes;
	}

	// PREENCHE A TABELA HTML COM AS TURMA RETORNADAS PELO FILTRO NA PARTE DE PESQUISA
	function PreencherTabelaResultados(dados){
		if (dados.length == 0){
			$("#resultado_turmas").html(
				SetarTabelaMensagem("#resultado_turmas", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#resultado_turmas").html(
			"<tbody>"			 	    +
			"<tr>"				        +
				"<th> ID 		 </th>" +
				"<th> Curso 	 </th>" +
				"<th> Sem/Ano 	 </th>" +
				"<th> Descrição  </th>" +
				"<th> H. Inicial </th>" +
				"<th> H. Final   </th>" +
				"<th> </th>"            +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTRO DA TABELA
		$.each(dados, function(i, turma){
			var descricao  		= (turma["descricao"] === "" ? "-" : turma["descricao"]);
			var horario_inicial = (turma["horario_inicial"] === "" ? "-" : turma["horario_inicial"]);
			var horario_final   = (turma["horario_final"] === "" ? "-" : turma["horario_final"]);

			/** TR CLASS='TR_RESULTADO': ID DA TURMA. 
				USADO PARA CARREGAR SUAS INFORMAÇÕES PARA ALTERAÇÃO OU PARA EXCLUSÃO.
				CLASS='EXCLUIR_TURMA': RESPONSÁVEL POR INFORMAR QUE O REGISTRO SERÁ 
				EXCLUÍDO AO SER CLICADO **/ 
			$("#resultado_turmas").append(
				"<tr class='tr_resultado' id='" + turma["id"] 		   + "'>"    +
					"<td>" + PadLeft(turma["id"], 4)          	       + "</td>" +
					"<td>" + turma["titulo"] 				  		   + "</td>" +
					"<td>" + turma["semestre"] + "Sem/" + turma["ano"] + "</td>" +
					"<td>" + descricao			  	  	               + "</td>" +
					"<td>" + horario_inicial		  	         	   + "</td>" +
					"<td>" + horario_final   		  	         	   + "</td>" +
					"<td><span class='excluir-turma glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);
		});

		$("#resultado_turmas").append("</tbody>");
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	// BUSCA TODOS OS CURSOS CADASTRADOS NÃO CANCELADOS 
	// E POPULA OS SELECTS COM OS DADOS RETORNADOS
	function CarregarCursos(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "turmas",
				carregar_cursos: true	
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar os cursos.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				PreencherCursos("#c_curso", dados);
				PreencherCursos("#p_curso", dados);
			}
		});
	}

	// BUSCA TODOS OS PROFESSORES VÁLIDOS E POPULA O SELECT RELACIONADO 
	function CarregarProfessores(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "turmas",
				carregar_professores: true	
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar os professores.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				PreencherProfessores("#c_docentes", dados);
			}
		});
	}

	// FUNÇÃO RESPONSÁVEL POR CADASTRAR/ALTERAR A TURMA
	function SalvarTurma(){
		var docentes = GerarArrayDocentes();
		var dias     = GerarStrDias();

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela:   	     "turmas",
				id: 		     $("#c_id").val(),
				id_curso: 	     $("#c_curso").val(),
				descricao:       $("#c_descricao").val(),
				semestre:        $("#c_semestre").val(),
				ano: 		     $("#c_ano").val(),
				data_inicio:     $("#c_data_inicial").val(),
				data_fim:        $("#c_data_final").val(),
				carga_horaria:   $("#c_carga_horaria").val(),
				horario_inicial: $("#c_horario_inicial").val(),
				horario_final:   $("#c_horario_final").val(),
				id_dias: 	     $("#dias").val(),
				dias: 		     JSON.stringify(dias),
				docentes: 	     JSON.stringify(docentes)
			},
			error: function(e){
				console.log(e);
				alert("Erro ao salvar turma.");
			},
			success: function(data){
				if (!data["Status"]){	
					alert(data["Mensagem"]);
					return;
				}

				if (!$("#c_id").val()){
					$status = "cadastrada";
				} else {
					$status = "alterada";
				}

				$("#resetar_turma").click();

				alert("Turma " + $status + " com sucesso.");
			}
		});
	}

	// CANCELA O REGISTRO NA TABELA DOCENTES
	function CancelarDocente(id_tabela){
		var turma   = id_tabela;
		var retorno = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "turmas",
				cancelar_docente: true,
				id: 	turma
			},
			error: function(e){
				console.log(e);
				retorno = false;
			},
			success: function(data){
				if (!data["Status"]){
					retorno = false;
				} else {
					retorno = data["Dados"];
				}
			}
		});

		return retorno;
	}

	function CancelarTurma(id_turma){
		var turma   = id_turma;
		var retorno = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "turmas",
				id: 	turma
			},
			error: function(e){
				console.log(e);
				retorno = false;
			},
			success: function(data){
				if (!data["Status"]){
					retorno = false;
				} else {
					retorno = data["Dados"];
				}
			}
		});

		return retorno;	
	}

	function FiltrarTurmas(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela:    "turmas",
				id: 	   $("#p_id").val(),
				curso: 	   $("#p_curso").val(),
				semestre:  $("#p_semestre").val(),
				ano: 	   $("#p_ano").val(),
				descricao: $("#p_descricao").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível retornar os professores.");
			},
			success: function(data){
				if (!data["Status"]) {	
					alert(data["Mensagem"]);
					return;
				}

				PreencherTabelaResultados(data["Dados"]);
				LimparFiltros(false);
			}
		});
	}

	function CarregarTurma(id_turma){
		var turma   = id_turma;
		var retorno = true;

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType:"json",
			data: {
				tabela: "turmas",
				id: 	 turma
			},
			error: function(e){
				retorno = false;
				console.log(e);
				alert("Não foi possível carregar os dados da turma.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}
		
				dados = JSON.parse(data["Dados"]);
				LimparCamposCadastros();

				$("#c_id").val(dados["id"]);
				$("#c_descricao").val(dados["descricao"]);
				$("#c_ano").val(dados["ano"]);
				$("#c_data_inicial").val(dados["data_inicio"]);
				$("#c_data_final").val(dados["data_fim"]);
				$("#c_carga_horaria").val(dados["carga_horaria"]);
				$("#c_horario").val(dados["horario"]);
				// É O ID DA TABELA TURMAS_DIAS USADO PARA EDITAR OS DIAS
				$("#dias").val(dados["id_dias"]); 

				var semestre = dados["semestre"];
				var curso    = dados["titulo"];
				var dias     = dados["Dias"];
				var docentes = dados["Docentes"];

				$("#c_semestre option:contains(" + semestre + ")").prop("selected", true);
				$("#c_curso option:contains(" + curso + ")").prop("selected", true);

				$("input[type=checkbox]").each(function(i) {
					$(this).prop("checked", dias[i]);
				});

				AdicionarDocentesCadastrados(docentes)
			}
		});

		return retorno;
	}

	/*************************************************************/
	/************************** EVENTOS **************************/
	/*************************************************************/
	$("#salvar_turma").click(function(){
		SalvarTurma();
	});

	$("#resetar_turma").click(function(){
		LimparCamposCadastros();
		LimparFiltrosDocentes(true);
	});

	$("#adicionar_docente").click(function(){
		AdicionarDocentes();
	});

	$("#btn_limpar_filtros_docentes").click(function(){
		LimparFiltrosDocentes(false);
	});

	$("#btn_limpar_filtros_turmas").click(function(){
		LimparFiltros(true);
	});

	$("#filtrar_turmas").click(function(){
		FiltrarTurmas();
	});

	$("#docentes_cadastrados").on("click", ".excluir-docente", function(){
		// ID DO CADASTRO DO DOCENTE NO DB
		var id = $(this).parent().parent().attr("id"); 

		if (id) {
			status = CancelarDocente(id);

			if (status) {
				$(this).parent().parent().remove();
			} else {
				alert("Não foi possível excluir o docente.");
			}

			return;
		}

		$(this).parent().parent().remove();
	});	

	$("#resultado_turmas").on("click", ".excluir-turma", function(){
		var id 		 = $(this).parent().parent().attr("id");
		var resposta = confirm("Deseja mesmo excluir a turma?");

		if (resposta) {
			var status = CancelarTurma(id);
			$("#filtrar_turmas").click();

			if (!status) {
				alert("Não foi possível excluir a turma.");
			}
		}
	});	

	$("#resultado_turmas").on("dblclick", ".tr_resultado", function(){
		var status = CarregarTurma($(this).attr("id"));
		
		if (status) {
			$("#tab_turmas").tabs().tabs({active: 0});
			$("#tab_cadastrar").click();
		}
	});
});