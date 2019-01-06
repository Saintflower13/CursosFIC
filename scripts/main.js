$(function(){
	$(".valida-rg").keyup(function(e){
		e.preventDefault();
        var exp = /[^\d\w]/g;
        $(this).val($(this).val().replace(exp, ""));
	});

	$(".apenas-inteiro").keyup(function(e){
        e.preventDefault();
        var exp = /[^\d]/g;
        $(this).val($(this).val().replace(exp, ""));
    });

	window.PadLeft = function(str, length){
		return str > 9999 ? str : ("0000" + str).slice(-4);
	}

	// DESCRIÇÃO É O "NOME" DA CHAVE A SER ACESSADO 
	// VALUE É O "NOME" DA CHAVE QUE SERÁ ALOCADO NO VALUE
	window.PreencherSelect = function(select, dados, descricao, value){
		$.each(dados, function(i, registro){
			var o = new Option("option " + registro[descricao], registro[value]);
			$(o).html(registro[descricao]);
			$(select).append(o);
		});
	}

	window.SetarTabelaMensagem = function(tabela, msg){
		$(tabela).html(
			"<tbody>"								    	 +
				"<tr class='tabela-nenhum-registro'>" 		 +
					"<td class='tabela-resultados-mensagem'>"+
						msg									 +
					"</td>"									 +
				"</tr>" 									 +
			"</tbody>"
		);
	}

	window.FormatarDocumento = function(doc){
		return doc;
		/*switch(doc.length){
			case 11:
				return doc.substring(0,3) + "." + doc.substring(3,3) + "." + doc.substring(6,3) + "-" doc.substring(9,2);
				break;

			case 9:
				return doc.substring(0,2) + "." + doc.substring(2,3) + "." + doc.substring(5,3) + "-" doc.substring(8,1);
				break;
		} */
	}

	// RETORNA DO BANCO UM ÚNICO CAMPO DA TABELA INFORMADA 
	window.PegarInformacaoSimples = function(tabela_, campo_, condicao_, valor_padrao_){
		var retorno = valor_padrao_;

		$.ajax({
			async: false,
			type: "POST",
			url: "../../../db/cadastros/obter_informacao.php",
			data: {
				tabela: 	  tabela_,
				campo:  	  campo_,
				condicao: 	  condicao_,
				valor_padrao: valor_padrao_
			},
			error: function(e){
				console.log(e);
				retorno = valor_padrao_;
			},
			success: function(data){
				retorno = data;
			}
		});
		
		return retorno;
	}

	window.CarregarTurma = function(caminho_arquivo, id_turma){
		var retorno = false;

		$.ajax({
			async: false,
			type: "POST",
			url: caminho_arquivo,
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_turma: true,
				id: id_turma	
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

				retorno = JSON.parse(data["Dados"]);
			}
		});	

		return retorno;
	}

	window.PreencherAno = function(input){
		var ano = new Date();
		$(input).val(ano.getFullYear());
	}

	window.CarregarParticipantesMatriculados = function(caminho_arquivo, id_turma) {
		var retorno = false;

		$.ajax({
			async: false,
			type: "POST",
			url: caminho_arquivo,
			dataType: "json",
			data: {
				tabela: "matriculas",
				carregar_participates: true,
				id: id_turma
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

				retorno = data["Dados"];
			}
		});	

		return retorno;		
	}

	window.PreencherTurmas =  function(select, id_inicial, dados){
		$(select).html("<option id='" + id_inicial + "' value='0'> Turma </option>");

		$.each(dados, function(i, registro){
			var o = new Option("option " + registro["descricao"], registro["id"]);

			if (registro["descricao"] !== "") {
				$(o).html(PadLeft(registro["id"], 4) + " - " + registro["descricao"] + " [" + registro["horario_inicial"] + " - " + registro["horario_final"] + "]");
			} else {
				$(o).html(PadLeft(registro["id"], 4) + " - [" + registro["horario_inicial"] + " - " + registro["horario_final"] + "]");	
			}

			$(select).append(o);
		});
	}

	window.GerarHeaderTurma = function(dados) {
		var descricao_turma = "[" + dados.titulo + "] " + PadLeft(dados.id, 4) + " - "; 

		if (dados.descricao !== "") {
			descricao_turma += dados.descricao + ", ";
		}

		if (dados.semestre !== "" && dados.ano !== "") {
			descricao_turma += dados.semestre + " Sem/" + dados.ano + ", ";
		}

		if (dados.horario_inicial !== "") {
			descricao_turma += dados.horario_inicial;

			if (dados.horario_final != "") {
				descricao_turma += " - " + dados.horario_final;	
			}
		}

		if (dados.Dias.length > 0) {
			var dias_extenso = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];
			var dias_aulas   = "";

			$.each(dados.Dias, function(i, dia){
				if (dia == "1") {
					if (dias_aulas == "") {
						dias_aulas = ", " + dias_extenso[i];
						return true;
					}

					dias_aulas += "-" + dias_extenso[i];
				}
			});

			descricao_turma += dias_aulas;
		}

		return descricao_turma;
	}

	function Deslogar() {
		var caminho   = "../";
		var url_atual = window.location.href;
		url_atual     = url_atual.split("/");

		if (url_atual.length == 8) {
			caminho += "../";
		}

		$.ajax({
			type: "POST",
			url: caminho + "../db/logar.php",
			dataType: "json",
			data: {
				deslogar: true
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível deslogar.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				window.location.replace(caminho);
			}
		});
	}

	$("#btn_logout").click(function(){
		Deslogar();
	});

	$("#btn-menu-toggle").click(function(){
		$("#sidebar").toggle("fast");
	});
});
