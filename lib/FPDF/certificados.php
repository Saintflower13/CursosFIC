<?php
	include_once "banco.php";

	// $participantes ARRAY COM AS INFORMAÇÕES DO(S) PARTICIPANTE(S) PARA GERAR O PDF
	function GerarCertificadoParticipante($participantes, $id_turma) {
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		$fpdf = new FPDF('L', 'mm', 'A5');	

		$InfoTurma = GetTurma($id_turma);

		for ($i = 0; $i < count($participantes); $i++) {
			$fpdf->SetMargins(26, 60);
			$fpdf->AddPage();
			$fpdf->Image('bg.png', 0, 0, 210, 149);

			$fpdf->SetFont('Arial', '', 14);
			$fpdf->SetTextColor(0, 0, 0);

			$fpdf->MultiCell(160, 6, utf8d('O Instituto Federal de Educação, Ciência e Tecnologia de São Paulo, câmpus Campos do Jordão, certifica que'), 0, 'C', false);

			$fpdf->Ln(6);

			$fpdf->SetFont('Arial', 'i', 22);
			$fpdf->Cell(160, 8, utf8d($participantes[$i]['Nome']), 0, 1, 'C');

			$fpdf->Ln(0.5);

			$fpdf->SetFont('Arial', '', 10);

			$fpdf->Cell(160, 5, 'portador(a) do ' .$participantes[$i]['tipo_doc']. ' ' .$participantes[$i]['numero_doc']. ' do(a) Curso', 0, 1, 'C');

			$fpdf->SetFont('Arial', 'b', 10);
			$fpdf->Cell(160, 5, utf8d($InfoTurma[0]['Titulo']), 0, 1, 'C');
			$fpdf->SetFont('Arial', '', 10);

			$fpdf->Cell(160, 5, 'realizado neste campus e ministrado por ' .utf8d($InfoTurma[0]['Professor']), 0, 1, 'C');
			$fpdf->Cell(160, 5, utf8_decode('no período de ') .DataExtensa($InfoTurma[0]['data_inicio']). ' a ' .DataExtensa($InfoTurma[0]['data_fim']). ',', 0, 1, 'C');
			$fpdf->Cell(160, 5, 'totalizando ' .$InfoTurma[0]['carga_horaria']. utf8_decode(' hora(s), em Campos do Jordão/SP.'), 0, 1, 'C');
			$fpdf->Cell(160, 5, utf8d('conforme os termos da Lei nº 9394/96 e do Decreto nº 5154/2004.'), 0, 1, 'C');

			$fpdf->Ln(5);

			$fpdf->Cell(160, 5, utf8d('Campos do Jordão, ') .DataExtensa(date('Y-m-d')). '.', 0, 1, 'C');


			// *** SEGUNDA PÁGINA ***
			$fpdf->SetMargins(10, 20);
			$fpdf->AddPage();
			$fpdf->Image('bg2.png', 0, 0, 210, 149);

			$fpdf->SetFont('Arial', '', 8);

			// EMENTAs
			$assunto = 	preg_split('/\r\n|\r|\n/', $InfoTurma[0]['ementa']);

			for ($j = 0; $j < count($assunto); $j++) {
				$fpdf->Cell(100, 3.5, utf8d($assunto[$j]), 0, 1, 'L');	
			}

			$fpdf->SetTextColor(110, 110, 110);
			$fpdf->SetFont('Arial', 'i', 9);
			$fpdf->SetY(89);
			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode('Este certificado foi registrado sob o nº ') .$participantes[$i]['registro_numero']. ',', 0, 1, 'C');

			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode('página ') .$participantes[$i]['registro_pagina']. ', livro ' .$participantes[$i]['registro_livro']. '.', 0, 1, 'C');

			$fpdf->Ln(8);
			$fpdf->SetX(123);
			$fpdf->Cell(75, 4, utf8_decode('Campos do Jordão, ') .DataExtensa(date('Y-m-d')). '.', 0, 1, 'C');
		} 

		$fpdf->Output('F', 'TESTE.pdf'); //utf8d($InfoTurma[0]['Titulo'])
	}
?>