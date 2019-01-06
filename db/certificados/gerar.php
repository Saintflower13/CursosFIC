<?php
	include_once "../base/executa_query.php";
	include_once "../base/constantes.php";
	include_once "../base/tipos.php";
	require_once "../../lib/FPDF/fpdf.php";

	function GerarCaminho($titulo_curso, $participante) {
		$caminho  = CAMINHO_CERTIFICADO_TMP .$titulo_curso;

		if ($participante !== "") {
			$caminho .= "_" .$participante;
		}

		$caminho .= ".pdf";	

		return str_replace(" ", "_", $caminho);
	}

	function GerarCertificadoParticipante($turma, $participantes, $tipo) {
		setlocale(LC_TIME, "pt_BR", "pt_BR.utf-8", "pt_BR.utf-8", "portuguese");
		$fpdf = new FPDF("L", "mm", "A5");

		if (count($turma) < 1) {
			echo "0";
			die();
		}

		if (count($participantes) < 1) {
			echo "1";
			die();
		}

		for ($i = 0; $i < count($participantes); $i++) {
			$fpdf->SetMargins(26, 60);
			$fpdf->AddPage();

			$fpdf->Image(IMG_CERTIICADO_FRENTE, 0, 0, 210, 149);

			$fpdf->SetFont("Arial", "", 14);
			$fpdf->SetTextColor(0, 0, 0);

			$fpdf->MultiCell(160, 6, utf8d("O Instituto Federal de Educação, Ciência e Tecnologia de São Paulo, câmpus Campos do Jordão, certifica que"), 0, "C", false);

			$fpdf->Ln(6);

			$fpdf->SetFont("Arial", "i", 22);
			$fpdf->Cell(160, 8, utf8d($participantes[$i]["nome"]), 0, 1, "C");

			$fpdf->Ln(0.5);

			$fpdf->SetFont("Arial", "", 10);

			$fpdf->Cell(160, 5, "portador(a) do " .GetTipoDocumento($participantes[$i]["tipo_documento"]). " " .$participantes[$i]["numero_documento"]. " participou do(a) Curso", 0, 1, "C");

			$fpdf->SetFont("Arial", "b", 10);
			$fpdf->Cell(160, 5, utf8d($turma[0]["titulo"]), 0, 1, "C");
			$fpdf->SetFont("Arial", "", 10);

			$titulo = utf8d($turma[0]["professor"]);
			$fpdf->Cell(160, 5, "realizado neste campus e ministrado por " .utf8d($turma[0]["professor"]), 0, 1, "C");
			$fpdf->Cell(160, 5, utf8_decode("no período de ") .DataExtensa($turma[0]["data_inicio"]). " a " .DataExtensa($turma[0]["data_fim"]). ",", 0, 1, "C");
			$fpdf->Cell(160, 5, "totalizando " .$turma[0]["carga_horaria"]. utf8_decode(" hora(s), em Campos do Jordão/SP."), 0, 1, "C");
			$fpdf->Cell(160, 5, utf8d("conforme os termos da Lei nº 9394/96 e do Decreto nº 5154/2004."), 0, 1, "C");

			$fpdf->Ln(5);

			$fpdf->Cell(160, 5, utf8d("Campos do Jordão,"). " " .DataExtensa(date("Y-m-d")). ".", 0, 1, "C");


			/***********************************/
			/********* SEGUNDA PÁGINA *********/
			/*********************************/
			$fpdf->SetMargins(10, 20);
			$fpdf->AddPage();
			$fpdf->Image(IMG_CERTIICADO_VERSO, 0, 0, 210, 149);

			$fpdf->SetFont("Arial", "", 8);

			// EMENTA
			$assunto = 	preg_split("/\r\n|\r|\n/", $turma[0]["ementa"]);

			for ($j = 0; $j < count($assunto); $j++) {
				$fpdf->Cell(100, 3.5, utf8d($assunto[$j]), 0, 1, "L");	
			}

			$fpdf->SetTextColor(110, 110, 110);
			$fpdf->SetFont("Arial", "i", 9);
			$fpdf->SetY(89);
			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode("Este certificado foi registrado sob o nº ") .$participantes[$i]["registro_numero"]. ",", 0, 1, "C");

			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode("página ") .$participantes[$i]["registro_pagina"]. ", livro " .$participantes[$i]["registro_livro"]. ".", 0, 1, "C");

			$fpdf->Ln(8);
			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode("Campos do Jordão, ") .DataExtensa(date("Y-m-d")). ".", 0, 1, "C");
		} 


		if ($tipo == "I") {
			$caminho = GerarCaminho(utf8d($turma[0]["titulo"]), utf8d($participantes[0]["nome"]));
		} else {
			$caminho = GerarCaminho(utf8d($turma[0]["titulo"]), "");
		}

		$fpdf->Output("F", $caminho); 

		// VALIDA SE O PDF FOI SALVO COM SUCESSO
		if (file_exists($caminho)) {
			return str_replace("\\", "\\\\", $caminho);
		} else {
		    return "";
		}
	}
?>