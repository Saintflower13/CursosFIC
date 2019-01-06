$(function(){
	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function LimparFiltros(limpar_tabela){
		$("#p_usuario").val("");

		if (limpar_tabela) {
			SetarTabelaMensagem("#resultado_usuarios", "Nenhum registro para exibir, no momento :)");	
		}
	}

	function PreencherTabelaResultados(dados){
		if (dados.length == 0){
			$("#resultado_usuarios").html(
				SetarTabelaMensagem("#resultado_usuarios", "Nenhum registro encontrado :(")
			);

			return;
		}

		// HEADER DA TABELA
		$("#resultado_usuarios").html(
			"<tbody>"				   +
			"<tr>" 					   +
				"<th> ID        </th>" +
				"<th> Usuário   </th>" +
				"<th> </th>"		   +
			"</tr>"
		);

		// LOOPA OS DADOS INFORMADOS E GERA OS REGISTROS NA TABELA
		$.each(dados, function(i, usuario){
			/** TR CLASS='TR_RESULTADO': ID DO USUÁRIO. 
				USADO PARA CARREGAR SUAS INFORMAÇÕES PARA ALTERAÇÃO OU PARA EXCLUSÃO.
				CLASS='EXCLUIR_USUARIO': RESPONSÁVEL POR INFORMAR QUE O REGISTRO SERÁ EXCLUÍDO **/ 
			$("#resultado_usuarios").append(
				"<tr class='tr_resultado' id='" + usuario["id"] + "'>"    +
					"<td>" + PadLeft(usuario["id"], 4)          + "</td>" +
					"<td>" + usuario["usuario"] 				+ "</td>" +
					"<td><span class='excluir-usuario glyphicon glyphicon-remove color-darkred'></span></td>" +
				"</tr>"
			);
		});

		$("#resultado_usuarios").append("</tbody>");
	}

	function GetNomeUsuario(id){
		return PegarInformacaoSimples("usuarios", "usuario", "id = " + id, "...");
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function SalvarUsuario(){
		$.ajax({
			type: "POST",
			url: "./../../../db/cadastros/cadastro_alteracao.php",
			dataType: "json",
			data: {
				tabela: 		 "usuarios",
				id: 			 $("#c_id").val(),
				usuario: 		 $("#c_usuario").val(),
				senha: 			 $("#c_senha").val(),
				senha_confirmar: $("#c_senha_confirmar").val()
			},
			error: function(e){
				console.log(e);
				alert("Erro ao cadastrar usuário.");
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

				$("#resetar_usuario").click();

				alert("Usuário " + $status + " com sucesso.");
			}
		});
	}

	function FiltrarUsuarios(){
		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/filtrar.php",
			dataType: "json",
			data: {
				tabela:  "usuarios",
				usuario: $("#p_usuario").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível retornar os usuários.");
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

	function CarregarUsuario(id_usuario){
		var usuario = id_usuario;
		var retorno = true;

		$.ajax({
			type: "POST",
			url: "../../../db/cadastros/carregar.php",
			dataType:"json",
			data: {
				tabela: "usuarios",
				id: 	 usuario
			},
			error: function(e){
				retorno = false;
				console.log(e);
				alert("Não foi possível carregar os dados do usuario.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				dados = data["Dados"];

				$("#c_id").val(dados[0]["id"]);
				$("#c_usuario").val(dados[0]["usuario"]);
			}
		});

		return retorno;
	}

	function ExcluirUsuario(id_usuario){
		var usuario = id_usuario;
		var retorno = true;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/excluir_cancelar.php",
			dataType: "json",
			data: {
				tabela: "usuarios",
				id: 	usuario
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
	$("#salvar_usuario").click(function(){
		SalvarUsuario();
	});

	$("#filtrar_usuarios").click(function(){
		FiltrarUsuarios();
	});

	$("#btn_limpar_filtros_usuarios").click(function(){
		LimparFiltros(true);
	});

	$("#resultado_usuarios").on("dblclick", ".tr_resultado", function(){
		var status = CarregarUsuario($(this).attr("id"));
		
		if (status) {
			$("#tabs_usuarios").tabs().tabs({active: 0});
			$("#tab_cadastrar").click();
		}
	});

	$("#resultado_usuarios").on("click", ".excluir-usuario", function(){
		var id 		 = $(this).parent().parent().attr("id");
		var nome 	 = GetNomeUsuario(id);
		var resposta = confirm("Deseja mesmo excluir o usuário " + nome + "?");

		if (resposta) {
			var status = ExcluirUsuario(id);
			$("#filtrar_usuarios").click();

			if (!status) {
				alert("Não foi possível excluir o usuário.");
			}
		}
	});
});