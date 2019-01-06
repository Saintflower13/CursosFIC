$(function(){
	$(".loading").css("display", "none");

	/********************************************************************/
	/************************** FUNÇÕES COMUNS **************************/
	/********************************************************************/
	function ParticipantesSelecionados(validar_email) {
		var selecionados  = "";

		$("#participantes_matriculados > tbody  > tr").each(function(){
			var checado       = $(this).children("td:first").children().children().is(":checked");
			var id_matricula  = parseInt($(this).attr("id"));

			if (!id_matricula || !checado) {
				return true;	
			}

			if (validar_email && ($(this).children().eq(3).html() == "-")) {
				return true;
			}

			selecionados += (selecionados == "" ? id_matricula : ("," + id_matricula));
		});	

		return selecionados;
	}

	/******************************************************************/
	/************************** FUNÇÕES AJAX **************************/
	/******************************************************************/
	function ApagarCertificado(caminho) {
		$.ajax({
			type: "POST",
			url: "../../db/cadastros/excluir_cancelar.php",
			data: { 
				tabela: "certificados",
				id: "0",
				url: caminho 
			},
			error: function(e){
				console.log(e);
			}
		});		
	}

	function ImprimirCertificados(matriculas) {
		if (matriculas == "") {
			alert("Nenhum participante selecionado.");
			return;
		}

		$.ajax({
			type: "POST",
			url: "../../db/certificados/imprimir.php",
			data: { 
				id_turma: $("#turma_selecionada").val(),
				matriculas: matriculas 
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível gerar os certificados.");
			},
			success: function(url){
				if (!url || url == "") {
					alert("Não foi possível gerar os certificados.");
					return;			
				}

				var msg = "";

				switch (url) {
					case "0": msg = "Não foi possível gerar o certificado. Informações da TURMA ausentes.";
					case "1": msg = "Não foi possível gerar o certificado. Informações de PARTICIPANTE(S) ausentes.";
				}

				if (msg !== "") {
					alert(msg);
					return;
				}

				// ABRE O PDF EM OUTRA ABA E EM SEGUIDA, 
				// APÓS 10 SEGUNDOS, REMOVE O ARQUIVO DA PASTA TMP
				// PARA GARANTIR QUE O PDF JÁ TENHA SIDO CARREGADO NO BROWSER
				window.open(url, "_blank"); 

				setTimeout(function(){ 
					ApagarCertificado(url); 
				}, 10000);
			}
		});
	}

	function EnviarCertificados(matriculas) {
		if (matriculas == "") {
			alert("Nenhum participante selecionado.");
			return;
		}

		$(".loading").css("display", "block");

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../../db/certificados/enviar.php",
			data: { 
				id_turma: $("#turma_selecionada").val(),
				matriculas: matriculas 
			},
			error: function(e){
				console.log(e);
				$(".loading").css("display", "none");
				alert("Não foi possível gerar os certificados.");
			},
			success: function(data) {
				$(".loading").css("display", "none");

				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return;
				}

				alert("Email(s) enviado(s) com sucesso.");
			}
		});
	}

	/*************************************************************/
	/************************** EVENTOS **************************/
	/*************************************************************/
	$("#btn_participante_imprimir_certificados").click(function(){
		ImprimirCertificados(ParticipantesSelecionados(false));
	});

	$("#btn_participante_enviar_certificados").click(function(){
		EnviarCertificados(ParticipantesSelecionados(true));
	});
});