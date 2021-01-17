<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require getBasePath('vendor/autoload.php');

function email($recipient, $file, $text){
    readConfig();

    if( !configValue('mail','username') OR 
        !configValue('mail','password') OR 
        !configValue('mail','host') OR 
        !configValue('mail','port')
    ){
        returnJsonErrorAndDie('no mail config');
    }

    $user = getUser();
    $body = <<<EOL
Hallo,<br><br>

anbei findest Du ein Sharepic mit dem Text<br>
<br>
<strong>$text</strong><br>
<br>
Es stammt vom Account "$user" bei <a href="https://sharepicgenerator.de/">sharepicgenerator.de</a>.<br>
<br>
<small>
    _______________________<br>
    Diese E-Mail wurde von <a href="https://sharepicgenerator.de/imprint.php">sharepicgenerator.de</a> gesendet. 
    Sollten Sie sie fälschlicherweise erhalten haben, wenden Sie sich bitte an
    <a href="MAILTO:mail@tom-rose.de">mail@tom-rose.de</a>.
</small>

EOL;

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = configValue('mail','host');                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = configValue('mail','username');                     // SMTP username
        $mail->Password   = configValue('mail','password');                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = configValue('mail','port');                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('noreply@sharepicgenerator.de', 'Sharepicgenerator');
        $mail->addAddress($recipient);     // Add a recipient

        // Attachments
        $mail->addAttachment($file, 'sharepic.png');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Neues Sharepic';
        $mail->Body    = utf8_decode($body);
        $mail->AltBody = strip_tags($body);

        $mail->send();
        returnJsonSuccessAndDie();
    } catch (Exception $e) {
        returnJsonErrorAndDie("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
