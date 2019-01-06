<?php
	include_once "../classes/certificados.php";

	$certificados 				     = new Certificado();
	$certificados->id_turma      	 = $_POST["id_turma"];
	$certificados->ids_participantes = $_POST["matriculas"];

	if (strlen($certificados->ids_participantes) == 0) {
		return "";
		die();
	}

	echo $certificados->GerarParticipantesCertificados();
?>