$(function(){
	$(".matricula-header-turma").css("display", "none");
	PreencherAno("#p_ano");
	CarregarParticipantesCadastrados();
	CarregarCursos();
	CarregarTurmas();

	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function ParticipanteSelecionado(id_participante) {
		var existe = false;

		$("#tabela_alunos_matriculados > tbody  > tr").each(function(){
			var id = parseInt($(this).children("td:first").attr("id"));

			if (!id) {
				return true;
			}

			if (id == id_participante) {
				existe = true;	
			}
		});	

		return existe;
	}

	function GerarArrayParticipantes() {
		var participantes = [];

		$("#tabela_alunos_matriculados > tbody  > tr").each(function(){
			var id_matricula = $(this).attr("id");

			if (!id_matricula || id_matricula > 0) {
				return true;
			}

			var id = parseInt($(this).children("td:first").attr("id"));
			participantes.push(id);
		});

		return participantes;
	}

	function SetarTurmaSelecionada(){
		if (!ValidarCampos()) {
			return;
		}

		CarregarTurma();
	}

	function AtribuirHeaderTurma(dados){
		$(".matricula-header-filtro").css("display", "none");
		$(".matricula-header-turma").css("display", "block");
		$("#turma_selecionada").val(dados["id"]);

		$(".matricula-header-turma span").html(GerarHeaderTurma(dados));
	}

	function ValidarCampos(){
		if ($("#p_turma").val() == "0") {
			alert("Nenhuma turma selecionada.");
			return false;
		}

		return true;
	}

	function PreencherParticipantesMatriculados(dados){
		AdicionarHeaderParticipantesCadastrar();
		
		$.each(dados, function(i, participante){
			var id_matricula 	= participante.id;
			var id_participante = participante.id_participante;
			var nome 			= participante.nome;
			var documento 		= participante.numero_documento;

			documento = (documento !== "" ? documento : "-");

			AdicionarParticipanteMatricular(id_matricula, id_participante, nome, documento);
		});
	}

	function AdicionarHeaderParticipantesCadastrar(){
		$("#tabela_alunos_matriculados").html(
			"<tbody>"		       	   +
			"<tr>"					   +
				"<th> ID 		</th>" +
				"<th> nome		</th>" +
				"<th> documento </th>" +
				"<th> </th>" 		   +
			"</tr>"
		);
	}

	function AdicionarParticipanteMatricular($id_matricula, $id, $nome, $documento){
		var estado_tabela = $("#tabela_alunos_matriculados").children('tbody').children('tr:first').attr("class");

		if (estado_tabela == "tabela-nenhum-registro") {
			AdicionarHeaderParticipantesCadastrar();
		}

		var documento = ($documento === "" ? "-" : $documento);

		$("#tabela_alunos_matriculados").append(
			"<tr id='"     + $id_matricula + "'>" 	 +
				"<td id='" + $id + "'> "   + PadLeft($id, 4) + " </td>" +
				"<td> "    + $nome 		   + " </td>" +
				"<td> "    + $documento    + " </td>" +
				"<td><span class='excluir-participante glyphicon glyphicon-remove color-darkred'></span></td>" +
			"</tr>"
		);

		$("#tabela_alunos_matriculados").append("</tbody>");
	}

	function LimparFiltrosParticipantesCadastrados(recarregar_participantes){
		$("#p_participantes").val("");

		if (recarregar_participantes) {
			CarregarParticipantesCadastrados();	
		}
	}

	function LimparFiltrosTurmas(){
		$("#sem_inicial").prop("selected", true);
		$("#turma_inicial").prop("selected", true);
		$("#curso_inicial").prop("selected", true);
		$("#sem_turma_inicial").prop("selected", true);
		PreencherAno("#p_ano");

		$(".matricula-header-filtro").css("display", "block");
		$(".matricula-header-turma").css("display", "none");
		$("#turma_selecionada").val("");

		CarregarTurmas();
	}

	function LimparTabelaMatriculados(){
		SetarTabelaMensagem("#tabela_alunos_matriculados", "Nenhum registro para exibir, no momento :)");
	}

	function PreencherParticipantesCadastrados(dados){
		if (dados.length == 0){
			$("#participantes_cadastrados").html(
				SetarTabelaMensagem("#participantes_cadastrados", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#participantes_cadastrados").html(
			"<tbody>"		       	   +
			"<tr>"					   +
				"<th> ID 		</th>" +
				"<th> nome		</th>" +
				"<th> documento </th>" +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTRO DA TABELA
		$.each(dados, function(i, participante){
			var documento = (participante["numero_documento"] === "" ? "-" : participante["numero_documento"]);

			$("#participantes_cadastrados").append(
				"<tr class='tr_resultado' id='" + participante["id"] + "'>" 	+
					"<td> " + PadLeft(participante["id"], 4)		 + " </td>" +
					"<td> " + participante["nome"] 					 + " </td>" +
					"<td> " + documento  		   					 + " </td>" +
				"</tr>"
			);
		});

		$("#participantes_cadastrados").append("</tbody>");
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function CarregarTurma(id_turma){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_turma: true,
				id: $("#p_turma").val()	
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar a turma.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				dados = JSON.parse(dados);
				
				AtribuirHeaderTurma(dados);
				CarregarParticipantesMatriculados(dados["id"]);
			}
		});	
	}

	function CarregarParticipantesMatriculados(id_turma) {
		var turma = id_turma;

		$.ajax({
			type: "POST",
			url: "../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_participates: true,
				id: turma
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar os participantes da turma.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				PreencherParticipantesMatriculados(dados);
			}
		});	
	}

	function CarregarParticipantesCadastrados(){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_participantes_cadastrados: true,
				filtro: $("#p_participantes").val()	
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar os participantes.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				PreencherParticipantesCadastrados(dados);
				LimparFiltrosParticipantesCadastrados(false);
			}
		});
	}

	function CarregarCursos(){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
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
				PreencherSelect("#p_curso", dados, "titulo", "id");
			}
		});
	}

	function CarregarTurmas(){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_turmas: true,
				id_curso: $("#p_curso").val(),
				semestre: $("#p_semestre").val(),
				ano: $("#p_ano").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível carregar as turmas.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];
				PreencherTurmas("#p_turma", "turma_inicial", dados);
			}
		});	
	}

	function CancelarMatricula(id_matricula) {
		var matricula = id_matricula;
		var retorno   = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				id: 	matricula
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

	function MatricularParticipantes(){
		var arr_participantes = GerarArrayParticipantes();

		$.ajax({
			async: false,
			type: "POST",
			url: "../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				id_turma: $("#turma_selecionada").val(),
				participantes: 	arr_participantes
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível efetuar a(s) matricula(s).");
			},
			success: function(data){
				if (!data["Status"]){
					alert(data["Mensagem"]);
					return;
				} 

				alert("Participante(s) matriculado(s) com sucesso.");
				$("#resetar_matriculas").click();
			}
		});	
	}

	/*************************************************************/
	/************************** EVENTOS **************************/
	/*************************************************************/
	$("#filtrar_participantes").click(function(){
		CarregarParticipantesCadastrados();	
	});

	$("#btn_limpar_filtros_participantes").click(function(){
		LimparFiltrosParticipantesCadastrados(true);	
	});

	$("#btn_limpar_filtros_matriculas").click(function(){
		LimparFiltrosTurmas();	
		LimparTabelaMatriculados();
	});

	$("#resetar_matriculas").click(function(){
		LimparFiltrosParticipantesCadastrados(true);
		LimparTabelaMatriculados();	
		LimparFiltrosTurmas();
	});

	$("#participantes_cadastrados").on("click", ".tr_resultado", function(){
		var id 		  = $(this).find("td").eq(0).text();
		var nome 	  = $(this).find("td").eq(1).text();
		var documento = $(this).find("td").eq(2).text();

		// VALIDA SE JÁ EXISTE UM PARTICIPANTE CARREGADO NA TABELA
		// DE MATRICULADOS, SÓ ADICIONA NA TABELA SE NÃO EXISTIR 
		var existe = ParticipanteSelecionado(id);

		if (!existe) {
			AdicionarParticipanteMatricular(0, parseInt(id), nome, documento);
		}
	});	

	$("#tabela_alunos_matriculados").on("click", ".excluir-participante", function(){
		// ID DO CADASTRO DO DOCENTE NO DB
		var id = $(this).parent().parent().attr("id"); 

		if (id > 0) {
			var status = confirm("Deseja cancelar matricula da(o) participante?");
			
			if (status) {
				status = CancelarMatricula(id);

				if (status) {
					$(this).parent().parent().remove();
				} else {
					alert("Não foi possível excluir a matricula.");
				}
			}

			return;
		}

		$(this).parent().parent().remove();
	});

	$("#selecionar_turma").click(function(){
		// CARREGAR PARTICIPANTES JÁ CADASTRADOS
		SetarTurmaSelecionada();
	});

	$("#btn_matricular").click(function(){
		if ($("#turma_selecionada").val() == "") {
			alert("Nenhuma turma selecionada.");
			return;
		}

		var registros = $('#tabela_alunos_matriculados > tbody > tr').length -1;

		if (registros == 0) {
			alert("Nenhum participante informado.");
			return false;
		
		}

		MatricularParticipantes();
	});

	$("#p_curso").blur(function(){
		CarregarTurmas();
	});

	$("#p_curso").change(function(){
		CarregarTurmas();
	});

	$("#p_semestre").blur(function(){
		CarregarTurmas();
	});

	$("#p_semestre").change(function(){
		CarregarTurmas();
	});

	$("#p_ano").blur(function(){
		CarregarTurmas();
	});

	$("#p_ano").change(function(){
		CarregarTurmas();
	});
});