<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '/usr/share/php/libphp-phpmailer/autoload.php';

//echo '
  //      <script>
    //            function redirect(){
      //                  var red = document.getElementById("redirect");
        //                red.click();
         //       }
        //</script>
//';


$mail = new PHPMailer;
$mail->isSendmail();
$mail->isHTML(False);
$mail->setFrom('titanic@aries.ssrc.msstate.edu', 'Titanic');

//Setting an alternative replay to address
$mail->addReplyTo('ssrc-support@lists.msstate.edu', 'SSRC Support');

//Who its sending to
$mail->addAddress ('ssrc-support@lists.msstate.edu');

//Subject Line
$mail->Subject = 'SSRC Inventory Relocation Form';

//Email Body
$mail->Body = "Here's that form you asked for!";

//Add Attachment
$mail->addAttachment('/www/tmp/report.pdf', 'report.pdf');
//send message & check for errors
if (!$mail->send()) {
	echo 'Mailer Error: '. $mail->ErrorInfo;
} else {
	echo 'Message Sent!';
}

//add timer here so you can see the message sent
header('Refresh: 2; URL=https://aries.msussrc.com/apps/workorder');
?>
