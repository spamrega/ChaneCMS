<?

class Mailer 
{
	public static function send ($to, $subject, $message)
	{
		require 'mailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = SMTP_HOST;
		$mail->SMTPAuth = true;                  
		$mail->Username = SMTP_USERNAME;          
		$mail->Password = SMTP_PASSWORD;                  
		$mail->SMTPSecure = 'tls';                         
		$mail->Port = SMTP_PORT;                                 

		$mail->setFrom(SMTP_FROM, SMTP_FROMNAME);
		$mail->addAddress($to); 
		$mail->addReplyTo(SMTP_FROM, 'Reply');

		$mail->isHTML(true);                              

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->send()) {			return true;
		} else {			return false;
		}
	}
}