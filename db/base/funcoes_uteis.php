<?php
	function utf8d($texto) {
		return utf8_decode(Trim($texto));
	}

	function DataExtensa($data) {
		return strftime("%d de %B de %Y", strtotime($data));
	}

	function DecodeRetornoJSON($status, $msg, $dados) {
		if ($dados == "") {
			$dados = "{}";
		}

		return $retorno = '{"Status": ' .$status. ', "Mensagem": "' .$msg. '", "Dados": ' .$dados. '}';
	}

	function ValidarEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
?>