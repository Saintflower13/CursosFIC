<!-- 
	ARQUIVO RESPONSÁVEL POR ATUALIZAR AS IMAGENS USADAS PARA GERAR OS CERTIFICADOS.
	POR MEIO DO $_POST, É RECEBIDO O NOME QUE O ARQUIVO RECEBERÁ QUANDO SALVO.
	$_FILES GUARDA AS INFORMAÇÕES DA IMAGEM.
	É FEITA UMA VERIFICAÇÃO NA EXTENSÃO DO ARQUIVO PARA EVITAR QUE SUBAM ARQUIVOS
	INCORRETAMENTE E/OU MALICIOSOS. SENDO EXTENSÕES ACEITAS: JPG, JPEG E PNG
-->
<html> 
<head> 
	<title>Upload de Imagem </title> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
<body style="background-color: gray; color: white;"> 
<?php 
	if (isset($_FILES["imagem"]["name"]) && $_FILES["imagem"]["error"] == 0) {
		$tmp  = $_FILES["imagem"]["tmp_name"]; 
		$nome = $_FILES["imagem"]["name"];

		/*  PEGA A EXTENSÃO DO ARQUIVO ENVIADO */
		$extensao = PathInfo($nome, PATHINFO_EXTENSION);
		$extensao = StrToLower($extensao);

		/* VERIFICA A EXTENSÃO DO ARQUIVO */
		if (!StrStr('.jpg;.jpeg;.png', $extensao)) {
			echo "Não foi possível atualizar o certificado. Tipo de arquivo inválido.<br> São aceitas as extensões: .jpg, .jpeg, .png";
			die();
		}
			
		$nome_final = $_POST["arquivo"];

		if ($nome_final === "") {
			echo "Não foi possível identificar o nome do arquivo a ser salvo.";
			die();
		}

		$caminho = "../../images/certificado/" .$nome_final. ".png";

		/* COPIA A IMAGEM PARA O DESTINO ACIMA */
		if (!Copy($tmp, $caminho)) { 
			echo "Não foi possivel salvar o arquivo.";
			die();
		} 

		echo "Arquivo salvo com sucesso.";

	} else {
		echo "Nenhum arquivo encontrado.";
	}	
?> 
</body> 
</html>

