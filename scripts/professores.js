$(function(){
	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function ConverterCargo(cargo){
		switch (cargo){
			case "0":
				return "Professor";
				break

			case "1":
				return "Palestrante";
				break;

			case "2":
				return "Técnico";
				break;

			case "3":
				return "Monitor";
				break;

			case "4":
				return "Administrativo";
				break;

			default:
				return "Cargo";
				break;
		}
	}

	function ConverterTipo(tipo){
		switch (tipo){
			case "1":
				return "Substutivo";
				break;

			case "2":
				return "Voluntário";
				break;

			default:
				return "EBTT";
				break;
		}

	}

	function LimparFiltros(limpar_tabela){
		$("#p_id").val("");
		$("#p_nome").val("");
		$("#p_cpf").val("");
		$("#p_prontuario").val("");
		$("#cargo_padrao").prop("selected", true);

		if (limpar_tabela) {
			SetarTabelaMensagem("#resultado_professores", "Nenhum registro para exibir, no momento :)");	
		}	
	}

	function PreencherTabelaResultados(dados){
		if (dados.length == 0){
			$("#resultado_professores").html(
				SetarTabelaMensagem("#resultado_professores", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#resultado_professores").html(
			"<tbody>"				    +
			"<tr>" 					    +
				"<th> ID 		 </th>" +
				"<th> Nome 		 </th>"	+
				"<th> CPF 		 </th>" +
				"<th> Prontuário </th>" +
				"<th> Cargo 	 </th>" +
				"<th> </th>"		    +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTRO DA TABELA
		$.each(dados, function(i, professor){
			var cpf        = professor["cpf"];
			var prontuario = professor["prontuario"]; 
			var cargo 	   = professor["cargo"];

			cpf 	   = (cpf === "" ? "-" : cpf);
			prontuario = (prontuario === "" ? "-" : prontuario);
			cargo  	   = (cargo === "" ? "-" : cargo);


			/** TR CLASS='TR_RESULTADO': ID DO PROFESSOR. 
				USADO PARA CARREGAR SUAS INFORMAÇÕES PARA ALTERAÇÃO OU PARA EXCLUSÃO.
				CLASS='EXCLUIR_PROFESSOR': RESPONSÁVEL POR INFORMAR QUE O REGISTRO SERÁ 
				EXCLUÍDO AO SER CLICADO **/ 
			$("#resultado_professores").append(
				"<tr class='tr_resultado' id='" + professor["id"] + "'>" +
					"<td>" + PadLeft(professor["id"], 4)          + "</td>" +
					"<td>" + professor["nome"] 					  + "</td>" +
					"<td>" + FormatarDocumento(cpf)				  + "</td>" +
					"<td>" + prontuario 			  	  		  + "</td>" +
					"<td>" + ConverterCargo(cargo) 				  + "</td>" +
					"<td><span class='excluir-professor glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);
		});

		$("#resultado_professores").append("</tbody>");
	}

	function GetNomeProfessor(id_professor){
		return PegarInformacaoSimples("professores", "nome",  "id = " + id_professor, "...");
	}



	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function SalvarProfessor(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela:   	"professores",
				id: 		$("#c_id").val(),
				nome: 		$("#c_nome").val(),
				cpf:   		$("#c_cpf").val(),
				prontuario: $("#c_prontuario").val(),
				email: 		$("#c_email").val(),
				cargo: 		$("#c_cargo").val(),
				tipo: 		$("#c_tipo").val()
			},
			error: function(e){
				alert("Erro ao cadastrar professor.");
				console.log(e);
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

				$("#resetar_professor").click();

				alert("Professor " + $status + " com sucesso.");
			}
		});
	}

	function FiltrarProfessores(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela:   	"professores",
				id: 		$("#p_id").val(),
				nome: 		$("#p_nome").val(),
				cpf: 		$("#p_cpf").val(),
				prontuario: $("#p_prontuario").val(),
				cargo: 		$("#p_cargo").val()
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

	function CarregarProfessor(id_professor){
		var professor = id_professor;
		var retorno   = true;

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType:"json",
			data: {
				tabela: "professores",
				id: 	 professor
			},
			error: function(e){
				retorno = false;
				console.log(e);
				alert("Não foi possível carregar os dados do(a) professor(a).");
			},
			success: function(data){
				console.log(data);
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];

				console.log(dados);
				// CONVERTE O INDEX DO BANCO PARA SEU RELATIVO ESCRITO
				$cargo = ConverterCargo(dados[0]["cargo"]);
				$tipo  = ConverterTipo(dados[0]["tipo"]);

				$("#c_id").val(dados[0]["id"]);
				$("#c_nome").val(dados[0]["nome"]);
				$("#c_cpf").val(dados[0]["cpf"]);
				$("#c_prontuario").val(dados[0]["prontuario"]);
				$("#c_email").val(dados[0]["email"]);
				$("#c_cargo option:contains(" + $cargo + ")").attr("selected", true);
				$("#c_tipo option:contains(" + $tipo + ")").attr("selected", true);
			}
		});

		return retorno;
	}

	function ExcluirProfessor(id_professor){
		var professor = id_professor;
		var retorno   = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "professores",
				id: 	professor
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
	$("#salvar_professor").click(function(){
		SalvarProfessor();	
	});

	$("#filtrar_professores").click(function(){
		FiltrarProfessores();
	});

	$("#btn_limpar_filtros_professores").click(function(){
		LimparFiltros(true);
	});

	$("#resetar_professor").click(function(){
		$("#cargo_padrao").prop("selected", true);
		$("#tipo_padrao").prop("selected", true);
	});

	$("#resultado_professores").on("click", ".tr_resultado", function(){
		var status = CarregarProfessor($(this).attr("id"));
		
		if (status) {
			$("#tabs_professores").tabs().tabs({active: 0});
			$("#tab_cadastrar").click();
		}
	});

	$("#resultado_professores").on("click", ".excluir-professor", function(){
		var id 		 = $(this).parent().parent().attr("id");
		var nome 	 = GetNomeProfessor(id);
		var resposta = confirm("Deseja mesmo excluir o(a) professor(a) " + nome + "?");

		if (resposta) {
			var status = ExcluirProfessor(id);
			$("#filtrar_professores").click();

			if (!status) {
				alert("Não foi possível excluir o(a) professor(a).");
			}
		}
	});	
});