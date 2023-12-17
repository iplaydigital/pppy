<?php

function getPHPmailer(){
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->CharSet	= "UTF-8";
	$mail->SMTPDebug  = 2;
	// $mail->From     = "web@pohpunpanyafoundation.org";
	// $mail->FromName = "pohpunpanyafoundation.org";
	$mail->isHTML(true); 
	$mail->SMTPAuth   = true; 

	$mail->Host = "smtp.pohpunpanyafoundation.org"; // SMTP server
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465; // พอร์ท
	$mail->Username = "web@pohpunpanyafoundation.org"; // account SMTP
	$mail->Password = "E2or068t_"; // รหัสผ่าน SMTP		

	// $mail->AddAddress("info@pohpunpanyafoundation.org", "pohpunpanyafoundation.org");		
	return $mail;
}


?>