<?Php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function mail_createP($data){
	return '<p style="color:#2d2c2f !important;font-family:Roboto,sans-serif;font-weight:400;padding:0;margin: 10px 0;text-align:left;line-height:24px !important;font-size:14px !important;">' . $data . '<p/>';
}
function mail_createRow($data){
	return '<div style="color:#2d2c2f !important;font-family:Roboto,sans-serif;font-weight:400;padding:0;margin: 2px 0;text-align:left;line-height:24px !important;font-size:14px !important;">' . $data . '<div/>';

}

function mail_createA($href, $name){
	return '<a href="' . $href . '" target="_blank" style="color:#0073e8 !important;text-decoration:none;border-bottom:1px dotted #148adc;padding-bottom:2px;font-size:12px;"> ' . $name . ' </a>';
}
function mail_getHTML($type = 'new',$main_data){ // main, new
	global $basedir;
	$tpl = file_get_contents($basedir . '/mail.tpls/' . $type . '.html');
	$tpl = str_replace('{{MAIL-DATA}}', $main_data, $tpl);
	$tpl = str_replace('{{APP_V}}', APP_V, $tpl);
	$tpl = str_replace('{{FUND_NAME}}', "FFDS", $tpl);

	return $tpl;

}
function send_mail($to,$Subject,$Body){
	$smtp_smtpsecure = 'ssl';
	$smtp_charset = 'utf-8';
	$smtp_smtpdebug = 2;
	$smtp_mail_to = '';
	$smtp_username = 'icifund@yandex.ru';
	$smtp_password = 'PT8WcJTNz7x4rj5JNsj2VtI';
	$smtp_port = 465;
	$smtp_host = 'smtp.yandex.ru';

	$mail = new PHPMailer(true);
	try {
		//Server settings
		$mail->SMTPDebug = $smtp_smtpdebug; //2
		$mail->isSMTP();
		$mail->Host       = $smtp_host; 
		$mail->SMTPAuth   = true; 
		$mail->Username   = $smtp_username;                  
		$mail->Password   = $smtp_password;                             
		$mail->SMTPSecure = $smtp_smtpsecure;                                  
		$mail->Port       = $smtp_port;
		$mail->Port       = $smtp_port;                                    
		$mail->CharSet    = $smtp_charset;
		//Recipients
		$mail->setFrom($smtp_username, 'ICI');
		//$mail->addAddress('vnoskov.tel@gmail.com', 'vnoskov.tel@gmail.com');     // Add a recipient
		$mail->addAddress($to, $to);     // Add a recipient

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $Subject;
		$mail->Body    = $Body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
		//echo 'Message has been sent';
	} catch (Exception $e) {
		//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>