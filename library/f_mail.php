<?php 

function kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message, $isHtml=TRUE, $auth=TRUE)
{

	// untuk hosting
	// ======================================
	// require '../PHPMailer/src/PHPMailer.php';
	// require '../PHPMailer/src/SMTP.php';
	// require '../PHPMailer/src/Exception.php';
    // ======================================

	include('../phpmailer/src/PHPMailer.php');
	include('../phpmailer/src/SMTP.php');
	include('../phpmailer/src/Exception.php');

	$mail 				= new PHPMailer\PHPMailer\PHPMailer();
	$mail->isSMTP();
	$mail->Host 		= $host;
	$mail->Username 	= $email_user_server;
	$mail->Password 	= $email_pass_server;
	$mail->Port 		= 465;
	$mail->SMTPAuth 	= $auth;
	$mail->SMTPSecure 	= 'ssl';
	$mail->setFrom($email_user_server, $name_sender);
	$mail->addAddress($email_receiver, $name_receiver);
	$mail->isHTML($isHtml);
	$mail->Subject 		= $subject;
	$mail->Body 		= $message;
	if ($mail->send()){
		return TRUE;
	}else{
		return FALSE;
	}
}

?>