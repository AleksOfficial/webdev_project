<?php
//This shit works. now it needs to be implemented with a dynamic input in the test.html file. perhaps change it to php?

$mail = new PHPMailer();
    $mail->isSMTP();

    var_dump(openssl_get_cert_locations());
    //$mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
    $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => true,
          'allow_self_signed' => false,
          
      )
      
      );
      var_dump($mail->SMTPOptions['ssl']);
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //$mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username='myfirstpythonscript28@gmail.com';
    $mail->Password='HSemViencL5R3tY';
    $mail->setFrom('myfirstpythonscript28@gmail.com');
    $mail->addAddress('aleks.jevtic315@gmail.com');
    $mail->Subject='PHPMailer Gmail SMTP test';
    //$mail->Body = "Hello World!";
    $mail->msgHTML(file_get_contents('test.html'));

    $mail->AltBody = 'This is a plain-text message body';
    if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
      echo 'Message sent!';
  }


  ?>