$(function(){
	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function ConverterTipoDocumento(tipo){
		switch(tipo) {
			case "0":
				return "CPF";
				break;

			case "1":
				return "RG";
				break;

			case "2":
				return "NASC";
				break

			default:
				return "CPF";
				break;
		} 
	}

	function LimparFiltros(limpar_tabela){
		$("#p_id").val("");
		$("#p_nome").val("");
		$("#p_numero_documento").val("");
		$("#p_email").val("");

		if (limpar_tabela) {
			SetarTabelaMensagem("#resultado_participantes", "Nenhum registro para exibir, no momento :)");	
		}
	}

	function PreencherTabelaResultados(dados){
		if (dados.length == 0){
			$("#resultado_participantes").html(
				SetarTabelaMensagem("#resultado_participantes", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#resultado_participantes").html(
			"<tbody>"				   +
			"<tr>" 					   +
				"<th> ID        </th>" +
				"<th> Nome      </th>" +
				"<th> Documento </th>" +
				"<th> Email     </th>" +
				"<th> </th>"		   +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTROS NA TABELA
		$.each(dados, function(i, participante){
			var documento = participante["numero_documento"];
			var email     = participante["email"]; 

			documento = (documento === "" ? "-" : documento);
			email 	  = (email === "" ? "-" : email);


			/** TR CLASS='TR_RESULTADO': ID DO PARTICIPANTE. 
				USADO PARA CARREGAR SUAS INFORMAÇÕES PARA ALTERAÇÃO OU PARA EXCLUSÃO.
				CLASS='EXCLUIR_PARTICIPANTE': RESPONSÁVEL POR INFORMAR QUE O REGISTRO SERÁ EXCLUÍDO **/ 
			$("#resultado_participantes").append(
				"<tr class='tr_resultado' id='" + participante["id"] + "'>"    +
					"<td>" + PadLeft(participante["id"], 4)          + "</td>" +
					"<td>" + participante["nome"] 					 + "</td>" +
					"<td>" + documento 			  					 + "</td>" +
					"<td>" + email 			  	  					 + "</td>" +
					"<td><span class='excluir-participante glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);
		});

		$("#resultado_participantes").append("</tbody>");
	}

	function GetNomeParticipante(id_participante){
		return PegarInformacaoSimples("participantes", "nome",  "id = " + id_participante, "...");
	}



	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function SalvarParticipante(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela:   		  "participantes",
				id: 			  $("#c_id").val(),
				nome: 			  $("#c_nome").val(),
				tipo_documento:   $("#c_tipo_documento").val(),
				numero_documento: $("#c_numero_documento").val(),
				email: 			  $("#c_email").val()
			},
			error: function(e){
				console.log(resultado);
				alert("Erro ao cadastrar participante.");
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

				$("#resetar_participante").click();

				alert("Participante " + $status + " com sucesso.");
			}
		});
	}

	function FiltrarParticipantes(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela:   		  "participantes",
				id: 			  $("#p_id").val(),
				nome: 			  $("#p_nome").val(),
				numero_documento: $("#p_numero_documento").val(),
				email: 			  $("#p_email").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível retornar os participantes.");
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

	function CarregarParticipante(id_participante){
		var participante = id_participante;
		var retorno		 = true;

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType:"json",
			data: {
				tabela: "participantes",
				id: 	 participante
			},
			error: function(e){
				retorno = false;
				console.log(e);
				alert("Não foi possível carregar os dados da(o) participante.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados 	      = data["Dados"];
				var documento = ConverterTipoDocumento(dados[0]["tipo_documento"]);

				$("#c_id").val(dados[0]["id"]);
				$("#c_nome").val(dados[0]["nome"]);
				$("#c_numero_documento").val(dados[0]["numero_documento"]);
				$("#c_email").val(dados[0]["email"]);
				$("#c_tipo_documento option:contains(" + documento + ")").attr("selected", true);
			}
		});

		return retorno;
	}

	function ExcluirParticipante(id_participante){
		var participante = id_participante;
		var retorno 	 = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "participantes",
				id: 	participante
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
	$("#salvar_participante").click(function(){
		SalvarParticipante();
	});

	$("#filtrar_participantes").click(function(){
		FiltrarParticipantes();
	});

	$("#btn_limpar_filtros_participantes").click(function(){
		LimparFiltros(true);
	});

	$("#resultado_participantes").on("dblclick", ".tr_resultado", function(){
		var status = CarregarParticipante($(this).attr("id"));
		
		if (status) {
			$("#tabs_participantes").tabs().tabs({active: 0});
			$("#tab_cadastrar").click();
		}
	});

	$("#resultado_participantes").on("click", ".excluir-participante", function(){
		var id 		 = $(this).parent().parent().attr("id");
		var nome 	 = GetNomeParticipante(id);
		var resposta = confirm("Deseja mesmo excluir a(o) participante " + nome + "?");

		if (resposta) {
			var status = ExcluirParticipante(id);
			$("#filtrar_participantes").click();

			if (!status) {
				alert("Não foi possível excluir a(o) participante.");
			}
		}
	});	
});