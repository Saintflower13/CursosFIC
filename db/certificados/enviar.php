<?php
	include_once "../classes/certificados.php";
	include_once "../base/funcoes_uteis.php";

	$certificados 				     = new Certificado();
	$certificados->id_turma      	 = $_POST["id_turma"];
	$certificados->ids_participantes = $_POST["matriculas"];

	if (strlen($certificados->ids_participantes) == 0) {
		return DecodeRetornoJSON("false", "Não foi possível identificar os participantes.", "");
		die();
	}

	echo $certificados->EnviarCertificados();
?>