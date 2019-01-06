$(function(){
	// LISTA OS PROFESSORES QUANDO A PÁGINA É CARREGADA
	CarregarProfessores();

	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function ConverterTipo(tipo){
		switch(tipo){
			case "0":
				return "Curso"; 
				break;

			case "1":
				return "Mini Curso";
				break;

			case "2":
				return "Palestra";
				break;

			default:
				return "Não identificado"; 
				break;
		}
	}

	function PreencherProfessores(select, dados){
		PreencherSelect(select, dados, "nome", "id");
	}

	function LimparFiltros(limpar_tabela){
		$("#p_id").val("");
		$("#p_titulo").val("");
		$("#tipo_inicial").prop("selected", true);
		$("#prof_inicial").prop("selected", true);

		if (limpar_tabela) {
			SetarTabelaMensagem("#resultado_cursos", "Nenhum registro para exibir, no momento :)");
		}
	}

	function PreencherTabelaResultados(dados){
		if (dados.length == 0){
			$("#resultado_cursos").html(
				SetarTabelaMensagem("#resultado_cursos", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#resultado_cursos").html(
			"<tbody>"				   			   +
			"<tr>" 					     		   +
				"<th> ID        			</th>" +
				"<th> Título      			</th>" +
				"<th> Tipo 					</th>" +
				"<th> Professor Responsável </th>" +
				"<th> </th>"		   			   +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTROS NA TABELA
		$.each(dados, function(i, curso){
			/** TR CLASS='TR_RESULTADO': ID DO CURSO. 
				USADO PARA CARREGAR SUAS INFORMAÇÕES PARA ALTERAÇÃO OU PARA EXCLUSÃO.
				CLASS='EXCLUIR_CURSO': RESPONSÁVEL POR INFORMAR QUE O REGISTRO SERÁ EXCLUÍDO **/ 
			$("#resultado_cursos").append(
				"<tr class='tr_resultado' id='" + curso["id"]  + "'>"    +
					"<td>" + PadLeft(curso["id"], 4)           + "</td>" +
					"<td>" + curso["titulo"] 				   + "</td>" +
					"<td>" + ConverterTipo(curso["tipo"])	   + "</td>" +
					"<td>" + curso["professor"] 			   + "</td>" +
					"<td><span class='excluir-curso glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);
		});

		$("#resultado_cursos").append("</tbody>");
	}

	function GetTituloCurso(id_curso){
		return PegarInformacaoSimples("cursos", "titulo",  "id = " + id_curso, "...");
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function CarregarProfessores(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType: "json",
			data: {
				tabela: "cursos",
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
				PreencherProfessores("#c_professor_responsavel", dados);
				PreencherProfessores("#p_professor_responsavel", dados);
			}
		});
	}

	function SalvarCurso(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela: "cursos",
				id: 	   $("#c_id").val(),
				titulo:    $("#c_titulo").val(),
				tipo: 	   $("#c_tipo").val(),
				descricao: $("#c_descricao").val(),
				campus:    $("#c_campus").val(),
				professor: $("#c_professor_responsavel").val(),
				ementa:    $("#c_ementa").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível salvar o curso.");
			},
			success: function(data){
				if (!data["Status"]){	
					alert(data["Mensagem"]);
					return;
				}

				if (!$("#c_id").val()){
					$status = "cadastrado";
				} else {
					$status = "alterado";
				}

				$("#resetar_curso").click();

				alert("Curso " + $status + " com sucesso.");
			}
		});
	}

	function FiltrarCursos() {
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela:   	  "cursos",
				id: 		  $("#p_id").val(),
				titulo: 	  $("#p_titulo").val(),
				tipo: 		  $("#p_tipo").val(),
				professor_id: $("#p_professor_responsavel").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível retornar os cursos.");
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

	function CarregarCurso(id_curso){
		var curso   = id_curso;
		var retorno	= true;

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType:"json",
			data: {
				tabela: "cursos",
				id: 	 curso
			},
			error: function(e){
				retorno = false;
				console.log(e);
				alert("Não foi possível carregar os dados do curso.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados    = data["Dados"];
				var tipo = ConverterTipo(dados["tipo"]);

				$("#c_id").val(dados[0]["id"]);
				$("#c_titulo").val(dados[0]["titulo"]);
				$("#c_descricao").val(dados[0]["descricao"]);
				$("#c_ementa").val(dados[0]["ementa"]);

				$("#c_tipo option:contains(" + tipo + ")").attr("selected", true);
				$("#c_professor_responsavel option:contains(" + dados[0]["professor"] + ")").attr("selected", true);
			}
		});

		return retorno;
	}

	function CancelarCurso(id_curso){
		var curso   = id_curso;
		var retorno = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "cursos",
				id: 	curso
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

	/*************************************************************/
	/************************** EVENTOS **************************/
	/*************************************************************/
	$("#salvar_curso").click(function(){
		SalvarCurso();
	});

	$("#filtrar_cursos").click(function(){
		FiltrarCursos();
	});

	$("#btn_limpar_filtros_cursos").click(function(){
		LimparFiltros(true);
	});

	$("#resultado_cursos").on("dblclick", ".tr_resultado", function(){
		var status = CarregarCurso($(this).attr("id"));
		
		if (status) {
			$("#tabs_cursos").tabs().tabs({active: 0});
			$("#tab_cadastrar").click();
		}
	});

	$("#resultado_cursos").on("click", ".excluir-curso", function(){
		var id 		 = $(this).parent().parent().attr("id");
		var titulo 	 = GetTituloCurso(id);
		var resposta = confirm("Deseja mesmo excluir o curso " + titulo + "?");

		if (resposta) {
			var status = CancelarCurso(id);
			$("#filtrar_cursos").click();

			if (!status) {
				alert("Não foi possível cancelar o curso.");
			}
		}
	});	
});