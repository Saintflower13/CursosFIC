$(function(){
	$(".participantes-header-turma").css("display", "none");
	PreencherAno("#p_participante_ano");

	CarregarCursos();
	CarregarTurmas("#p_participante_turma", "turma_inicial", 0, 0, $("#p_participante_ano").val());
	//CarregarTurmas("#p_professor_turma", "turma_inicial_prof", 0, 0, "");
	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function LimparTabelasParticipantes() {
		SetarTabelaMensagem("#participantes_matriculados", "Nenhum registro para exibir, no momento :)");
		SetarTabelaMensagem("#participantes_sem_email", "Nenhum registro para exibir, no momento :)");
	}

	function LimparFiltrosParticipantes() {
		$(".participante-header-filtro").css("display", "block");
		$(".participantes-header-turma").css("display", "none");

		PreencherAno("#p_participante_ano");
		$("#p_participante").val("");
		$("#sem_inicial").prop("selected", true);
		$("#curso_inicial").prop("selected", true);
		$("#turma_inicial").prop("selected", true);
		$("#selecionar_todos_participantes").prop("checked", false);
		CarregarTurmas("#p_participante_turma", "turma_inicial", 0, 0, "");
	}

	function LimparFiltrosProfessores() {
		$("#p_professor_ano").val("");
		$("#p_professor").val("");
		$("#sem_inicial_prof").prop("selected", true);
		$("#curso_inicial_prof").prop("selected", true);
		$("#turma_inicial_prof").prop("selected", true);	
	}

	function DisplayParticipantesSemEmail(){
		var display = "none";

		if ($("#mostrar_participantes_sem_email").is(":checked")) {
			display = "block";
		}

		$("#div_participantes_sem_email").css("display", display);
		$("#div_participantes_matriculados").toggleClass("col-sm-8");
	}

	function ValidarCampos() {
		if ($("#p_participante_turma").val() == "0") {
			alert("Nenhuma turma selecionada.");
			return false;
		}

		return true;	
	}

	function SetarTurmaSelecionada() {
		if (!ValidarCampos()) {
			return;
		}

		var dados = CarregarTurma("../../db/cadastros/carregar.php", $("#p_participante_turma").val());

		if (!dados) {
			alert("Não foi possível selecionar turma.");
			return;
		}

		AtribuirHeaderTurmaParticipantes(dados);
		CarregarParticipantes();
	}

	function AtribuirHeaderTurmaParticipantes(dados){
		$(".participante-header-filtro").css("display", "none");
		$(".participantes-header-turma").css("display", "block");

		$(".participantes-header-turma span").html(GerarHeaderTurma(dados));
		$("#turma_selecionada").val(dados["id"]);
	}

	function CarregarParticipantes() {
		var dados = CarregarParticipantesMatriculados("../../db/cadastros/filtrar.php", $("#p_participante_turma").val());

		if (!dados) {
			alert("Não foi possível carregar os participantes matriculados.");
			return;
		}

		PreencherParticipantesMatriculados(dados);
	}

	function PreencherParticipantesMatriculados(dados){
		AdicionarHeadersParticipantes();

		$.each(dados, function(i, participante){
			var email = participante.email;

			if (email == "") {
				AdicionarParticipanteSemEmail(participante);
			}

			AdicionarParticipante(participante);
		});
	}

	function AdicionarHeadersParticipantes() {
		$("#participantes_matriculados").html(
			"<tbody>"		       +
			"<tr>"				   +
				"<th> </th>"       +
				"<th> ID    </th>" +
				"<th> Nome  </th>" +
				"<th> Email </th>" +
			"</tr>"
		);

		$("#participantes_sem_email").html(
			"<tbody>"		       +
			"<tr>"				   +
				"<th> ID   </th>"  +
				"<th> Nome </th>"  +
			"</tr>"
		);
	}

	function AdicionarParticipante(participante){
		var email = (participante.email !== "" ? participante.email : "-");

		$("#participantes_matriculados").append(
			"<tr id='" + participante.id         + "'>" + // ID DA MATRICULA
				"<td class='checkbox col-xs-1'>" +
					"<label>"  +
						"<input id='" + participante.id_participante + "' class='checkbox-participante' type='checkbox'>" +
					"</label>" +
				"</td>" +
				"<td>"  +
					PadLeft(participante.id_participante, 4) +
				"</td>" +
				"<td>"  +
					participante.nome +
				"</td>" +
				"<td>"  +
					email +
				"</td>" +
			"</tr>"
		);
	}

	function AdicionarParticipanteSemEmail(participante){
		$("#participantes_sem_email").append(
			"<tr id='"     + participante.id + "'>" 	  +
				"<td id='" + participante.id_participante + "'> "    + PadLeft(participante.id_participante, 4) + " </td>" +
				"<td> "    + participante.nome 		      + " </td>" +
			"</tr>"
		);
	}

	function SelecionarTodosParticipantes(opcao) {
		$("#participantes_matriculados > tbody  > tr").each(function(){
			var checkbox      = $(this).children("td:first").children().children();
			var id_matricula  = parseInt($(this).attr("id"));

			if (!id_matricula) {
				return true;	
			}

			$(checkbox).prop("checked", opcao);
		});
	}

	function CarregarTurmasParticipantes() {
		var curso    = $("#p_participante_curso").val(); 
		var semestre = $("#p_participante_semestre").val();
		var ano      = $("#p_participante_ano").val();
		CarregarTurmas("#p_participante_turma", "turma_inicial", curso, semestre, ano);
	}

	function CarregarTurmasProfessores() {
		var curso    = $("#p_professor_curso").val();
		var semestre = $("#p_professor_semestre").val();
		var ano 	 = $("#p_professor_ano").val();
		CarregarTurmas("#p_professor_turma", "turma_inicial_prof", curso, semestre, ano);
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function CarregarCursos(){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
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
				PreencherSelect("#p_participante_curso", dados, "titulo", "id");
				//PreencherSelect("#p_professor_curso", dados, "titulo", "id");
			}
		});
	}

	function CarregarTurmas(select, id_inicial, curso, semestre, ano){
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_turmas: true,
				id_curso: curso,
				semestre: semestre,
				ano: ano
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
				PreencherTurmas(select, id_inicial, dados);
			}
		});	
	}

	/*************************************************************/
	/************************** EVENTOS **************************/
	/*************************************************************/
	$("#mostrar_participantes_sem_email").change(function(){
		DisplayParticipantesSemEmail();
	});

	$("#btn_limpar_filtros_participantes").click(function(){
		LimparFiltrosParticipantes();
		LimparTabelasParticipantes();
	});

	$("#btn_limpar_filtros_professores").click(function(){
		LimparFiltrosProfessores();
	});

	$("#selecionar_turma").click(function(){
		SetarTurmaSelecionada();
	});

	$("#selecionar_todos_participantes").on("change", function(){
		if ($(this).is(":checked")) {
			SelecionarTodosParticipantes(true);
			return;
		}

		SelecionarTodosParticipantes(false);
	});

	// FUNÇÕES PARA A PARTE DA TELA DE ATUALIZAÇÃO DO CERTIFICADO
	$("#cert_input_frente").change(function(){
		if ($(this).val()) {
			$("#cert_frente_ok").css("display", "inline");
		}
	});

	$("#cert_frente_limpar").click(function(){
		$("#cert_frente_ok").css("display", "none");	
	});

	$("#cert_input_verso").change(function(){
		if ($(this).val()) {
			$("#cert_verso_ok").css("display", "inline");
		}
	});

	$("#cert_verso_limpar").click(function(){
		$("#cert_verso_ok").css("display", "none");	
	});


	// ATUALIZAR SELECT DA TURMA (PARTICIPANTE)
	$("#p_participante_curso").blur(function(){
		CarregarTurmasParticipantes();
	});

	$("#p_participante_curso").change(function(){
		CarregarTurmasParticipantes();
	});

	$("#p_participante_semestre").blur(function(){
		CarregarTurmasParticipantes();
	});

	$("#p_participante_semestre").change(function(){
		CarregarTurmasParticipantes();
	});

	$("#p_participante_ano").blur(function(){
		CarregarTurmasParticipantes();
	});

	$("#p_participante_ano").change(function(){
		CarregarTurmasParticipantes();
	});

	// ATUALIZAR SELECT DA TURMA (PROFESSOR)
	$("#p_professor_curso").blur(function(){
		CarregarTurmasProfessores();
	});

	$("#p_professor_curso").change(function(){
		CarregarTurmasProfessores();
	});

	$("#p_participante_semestre").blur(function(){
		CarregarTurmasProfessores();
	});

	$("#p_participante_semestre").change(function(){
		CarregarTurmasProfessores();
	});

	$("#p_professor_ano").blur(function(){
		CarregarTurmasProfessores();
	});

	$("#p_professor_ano").change(function(){
		CarregarTurmasProfessores();
	});
});

