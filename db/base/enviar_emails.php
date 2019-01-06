<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	include_once "../../lib/vendor/vendor/autoload.php";
	include_once "../base/funcoes_uteis.php";

	/**
		CONFIGURA AS INFORMAÇÕES BÁSICAS NECESSÁRIAS PARA ENVIAR O EMAIL,
		EX: O SERVIDOR DE EMAIL, O REMETENTE, O METODO DE ENVIO, ETC
	**/
	function ConfigurarEmail(&$mail) {
		set_time_limit(120);

		$nome_remetente  = "IFSP - CJO Manu";
		include_once "email_remetente.php";

		$mail->IsHTML(true);
		$mail->CharSet = "utf-8";

		$mail->IsSMTP();
		$mail->Host       	 = "smtp.gmail.com";
		$mail->Port       	 = 587;
		$mail->SMTPAuth   	 = true;
		$mail->SMTPSecure 	 = "tls";
		$mail->Timeout       = 120;
		$mail->SMTPKeepAlive = true;

		$mail->Username   	 = $email_remetente;
		$mail->Password      = $senha_remetente;
		//$mail->SMTPDebug = 1;

		$mail->SetFrom($email_remetente, $nome_remetente);
		$mail->AddReplyTo($email_remetente, $nome_remetente);
	}

	/** DEFINE O(S) DESTINATÁRIO(S) PARA QUAL(IS) SERÁ(ÃO) ENVIADO(S) O(S) EMAIL(S) **/
	function AdicionaDestinatario(&$mail, $email_destino) {
		//for ($i = 0; $i < Count($email_destino); $i++) {
			$mail->AddAddress($email_destino, "Teste");
		//}
	}

	/**
		ADICIONA OS ANEXOS PARA SEREM ENVIADOS PELO EMAIL.
		O PADRÃO É:
		$VAR[]["CAMINHO"] 
		$VAR[]["NOME"]
	**/
	function AdicionarAnexos(&$mail, $caminho) {
		for ($i = 0; $i < Count($caminho); $i++) {
			$mail->addAttachment($caminho[$i]["caminho"], $caminho[$i]["nome"]);
		}
	}

	function EnviarEmail($email_destino, $email_assunto, $email_corpo, $anexos) {
		if (!isset($email_destino)) {
			return DecodeRetornoJSON("false", "Nenhum email de destino informado.", "");
			die();
		}

		if ($email_assunto === "" || $email_corpo === "") {
			return DecodeRetornoJSON("false", "Os campos assunto e corpo são obrigatórios.", "");
			die();
		}

		$mail = new PHPMailer();
		ConfigurarEmail($mail);
		AdicionaDestinatario($mail, $email_destino);

		if (count($anexos) > 0) {
			AdicionarAnexos($mail, $anexos);
		}

		$mail->Subject = $email_assunto;
		$mail->Body    = $email_corpo;
		$mail->AltBody = "Caso não consiga visualizar esta mensagem entre em contato com .";


		if(!$mail->Send()) {
			$retorno = DecodeRetornoJSON("false", $mail->ErrorInfo, "");
		} else {
			$retorno = DecodeRetornoJSON("true", "", "");
		} 

		$mail->SmtpClose();
		return $retorno;
	}	
?>