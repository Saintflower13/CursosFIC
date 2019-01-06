<?php
	require_once "lib/FPDF/fpdf.php";
	include_once "banco/funcoes_basicas.php";
	include_once "banco/gera_certificados.php";
	include_once "banco/executa_query.php";
	
	$participantes = GetParticipantes('2,5');
	GerarCertificadoParticipante($participantes, 1, 'F');
?>