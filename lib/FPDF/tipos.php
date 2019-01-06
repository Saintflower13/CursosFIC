<?php
	function GetTipoCurso($valor) {
		switch ($valor) {
			case "0":
				$tipo = 'Curso';
				break;
					
			case "1":
				$tipo = 'Mini Curso';
				break;

			case "2":
				$tipo = 'Palestra';
				break;

			default:
				$tipo = '';
				break;
		} 

		return $tipo; 		
	}

	function GetTipoDocumento($valor) {
		switch ($valor) {
			case "0":
				$tipo = 'CPF';
				break;
					
			case "1":
				$tipo = 'RG';
				break;

			case "2":
				$tipo = 'Certidao de Nascimento';
				break;

			default:
				$tipo = '';
				break;
		}

		return $tipo;
	}
?>