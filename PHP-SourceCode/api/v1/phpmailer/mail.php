<?php
/*##########Script Information#########
  # Purpose: Send mail Using PHPMailer#
  #          & Gmail SMTP Server 	  #
  # Created: 24-11-2019 			  #
  #	Author : Hafiz Haider			  #
  # Version: 1.0					  #
  # Website: www.BroExperts.com 	  #
  #####################################*/

//Include required PHPMailer files
	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

function emailVerification($name,$email,$otp){
	$emailText='<!DOCTYPE html><html>
    		    			<head><meta charset="UTF-8"><title>Website: Message</title></head>
    							<body style="margin:0px;"><div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
	<div style="margin:50px auto;width:70%;padding:20px 0">
	<div style="border-bottom:1px solid #eee">
		<a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">GoFood</a>
	</div>
	<p style="font-size:1.1em">Hi, <b>'.$name.'</b></p>
	<p>Thank you for choosingGoFood. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
	<h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$otp.'</h2>
	<p style="font-size:0.9em;">Regards,<br />Go Food</p>
	<hr style="border:none;border-top:1px solid #eee" />
	
	</div>
	</div></body></html>';

	$subjectText="Drugstore Verification";
// 	$mail = sendMail($email,$emailText,$subjectText);
	
	
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
// More headers
$headers .= "Reply-To: Drugstore<simplenet2016@gmail.com>\r\n";
$headers .= "Return-Path: Drugstore<simplenet2016@gmail.com>\r\n";
$headers .= "From: Drugstore <no-replay@gofood.com>\r\n";

mail($email,$subjectText,$emailText,$headers);
	
	
	
}
function resetPasswordMail($name,$email,$otp){
	$emailText='<!DOCTYPE html><html>
    		    			<head><meta charset="UTF-8"><title>Website: Message</title></head>
    							<body style="margin:0px;"><div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
	<div style="margin:50px auto;width:70%;padding:20px 0">
	<div style="border-bottom:1px solid #eee">
		<a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">GoFood</a>
	</div>
	<p style="font-size:1.1em">Hi, <b>'.$name.'</b></p>
	<p>Please use this OTP to reset your password.</p>
	<h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$otp.'</h2>
	<p style="font-size:0.9em;">Regards,<br />Go Food</p>
	<hr style="border:none;border-top:1px solid #eee" />
	
	</div>
	</div></body></html>';

	$subjectText="Reset Your Password";
// 	$mail = sendMail($email,$emailText,$subjectText);

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
// More headers
$headers .= "Reply-To: GoFood<simplenet2016@gmail.com>\r\n";
$headers .= "Return-Path: GoFood<simplenet2016@gmail.com>\r\n";
$headers .= "From: GoFood <no-replay@gofood.com>\r\n";

mail($email,$subjectText,$emailText,$headers);
}

function sendMail($email,$emailText,$subjectText){
	
//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
    $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages

//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "simplenet2016";
//Set gmail password
	$mail->Password = "simple2016";
//Set sender email
	$mail->setFrom('simplenet2016@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Email subject
	$mail->Subject = $subjectText;
//Attachment
	//$mail->addAttachment('img/attachment.png');
//Email body
	$mail->Body = $emailText;
//Add recipient
	$mail->addAddress($email);
	$mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
//Finally send email
    $mail->send();
//Closing smtp connection
	$mail->smtpClose();
}