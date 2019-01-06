<?php
	function utf8d($texto) {
		return utf8_decode(Trim($texto));
	}

	function DataExtensa($data) {
		return strftime('%d de %B de %Y', strtotime($data));
	}
?>