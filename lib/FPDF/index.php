<?php
	require_once "fpdf.php";
	include_once "funcoes_basicas.php";
	include_once "banco.php";
	include_once "certificados.php";
	
	GerarCertificadoParticipante(GetParticipantes('2,5'), 1);
?>