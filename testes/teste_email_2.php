<?php
	require_once 'lib/FPDF/fpdf.php';
	include_once 'banco/funcoes_basicas.php';
	include_once 'banco/gera_certificados.php';
	include_once 'banco/executa_query.php';
	include_once 'banco/envia_email.php';
	include_once 'banco/constantes.php';

	$ids_participantes = $_POST['id_participantes'];
	$id_turma		   = $_POST['id_turma'];
	$output    		   = $_POST['output'];

	if ($output == 'enviar_email') {
		$output = 'F';
	} else {
		if ($output == 'mostrar') {
			$output = '';
		} else {
			echo 'Valor Inválido!';
			die();
		}
	}

	if ($output == 'F') {
		$anexos = array();
		$ids    = explode(',', $ids_participantes);

		/** $EMAILS_ENVIADOS: ARRAY COM OS IDS E NOMES DOS PARTICIPANTES PARA OS QUAIS FORAM ENVIADOS OS EMAILS **/
		/** $EMAILS_NAO_ENVIADOS: ARRAY COM OS IDS, NOMES DOS PARTICIPANTES E MOTIVO POR QUAL NÃO FOI ENVIADO O EMAIL PARA TAL **/
		$emails_enviados     = array(); 
		$emails_nao_enviados = array();

		/**
			GERA OS CERTIFICADOS E OS MANIPULA BASEADO NA VARIAVEL $OUTPUT
			'F': ENVIA OS CERTIFICADOS PARA OS ALUNOS INFORMADOS SE ESTES POSSUIREM EMAIL CADASTRADO
			'' : GERA O CERTIFICADO E O EXIBE NA TELA DO BROWSER PADRÃO
		**/
		for ($i = 0; $i < Count($ids); $i++) {
			$email  = Get('participantes', 'email', 'id = ' .(string)$ids[$i]);
			$motivo = "";

			if (Count($email) > 0) {
				if (!is_null($email[0]['email'])) {
					$participantes = GetParticipantes($ids[$i]);
					$titulo        = QueryPura('SELECT T1.titulo FROM cursos AS T1 INNER JOIN turmas AS T2 ON T2.curso_id = T1.id WHERE T2.id = 1;', 'R');

					$anexos[0]['caminho'] = GerarCertificadoParticipante($participantes, $id_turma, $output);
					$anexos[0]['nome']    = $titulo[0]['titulo'];

					if ($titulo == '') {
						$titulo = 'Certificado.pdf';
					}

					if ($anexos[0]['caminho'] !== '') {
						$retorno = EnviarEmail($email, EMAIL_ASSUNTO, EMAIL_CORPO, $anexos);

						if ($retorno["status"]) {
							$participante_nome = Get("participantes", "nome", "id = " .(string)$ids[$i]);

							$emails_enviados[$i]["id"]   = $ids[$i];
							$emails_enviados[$i]["nome"] = $participante_nome[0]["nome"];
						} else {
							$motivo = $retorno["info"];
						}

						unlink($anexos[0]['caminho']);
					} else {
						$motivo = "Não foi possivel gerar o Certificado do participante.";
					}
				} else {
					$nome = Get("participantes", "nome", "id = " .(string)$ids[$i]);

					if ($nome !== "") {
						$motivo = "Participante não possui email cadastrado.";
					}		
				}
			}

			if ($motivo !== "") {
				$emails_nao_enviados[$i]["id"]     = $ids[$i];
				$emails_nao_enviados[$i]["nome"]   = Get("participantes", "nome", "id = " .(string)$ids[$i]);
				$emails_nao_enviados[$i]["motivo"] = $motivo;	
			}
		}

		echo "ENVIADOS: <br>";
		var_dump($emails_enviados);
		echo "<br><br>";

		echo "NAO ENVIADOS: <br>";
		var_dump($emails_nao_enviados);
		echo "<br><br>";		

	} else {
		$participantes = GetParticipantes($ids_participantes);
		GerarCertificadoParticipante($participantes, $id_turma, $output);
	}
?>