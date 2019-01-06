$(function(){
	$("#login_usuario").focus();
	
	function Logar(){
		$.ajax({
			type: "POST",
			url: "../db/logar.php",
			dataType: "json",
			data: {
				tabela: "login",
				usuario: $("#login_usuario").val(),	
				senha: $("#login_senha").val()
			},
			error: function(e){
				console.log(e);
				alert("Não foi possível efetuar login.");
			},
			success: function(data){
				if (!data["Status"]) {
					alert(data["Mensagem"]);
					return false;
				}

				window.location.replace("cadastros/participantes/index.php");
			}
		});
	}

	$("#btn_logar").click(function(){
		Logar();
	});

	$('#login_senha').keypress(function(e) {
		if (e.which == 13) {
	    	Logar();
	    }
	});
});