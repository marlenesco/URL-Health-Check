<?php
include 'inc/conf.php';
include 'vendor/autoload.php';

if (PHP_SAPI === 'cli')
{
    $args = getopt('u:');
    $url = $args['u'];
}
else
{
    exit('<h3 style="color: red;">This application requires php-cli (Command Line Interface)!</h3>');
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    exit("The scrit requires an URL parameter, ex: php index.php -uhttp://www.google.com\n\n");
}

$handle = curl_init($url);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

$response = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
curl_close($handle);


if ($httpCode !== 200) {
    sendWarning($httpCode);
} else {
    echo("The resource $url works fine.\n\n");
}

function sendWarning($httpCode) {
    global $url;
    $body  = "RESPONSE CODE: $httpCode\n";
    $body .= "DATE: " . date('Y-m-d H:i:s') . "\n";
    $body .= "URL: " . $url . "\n";

    $transporter = \Swift_SmtpTransport::newInstance(Config::SMTP_SERVER, Config::SMTP_PORT, Config::SMTP_SECURITY)
        ->setUsername(Config::SMTP_USER)
        ->setPassword(Config::SMTP_PASSWORD);

    $mailer =  \Swift_Mailer::newInstance($transporter);
    $transporter->start();

    $email = \Swift_Message::newInstance()
        ->setSubject(Config::HC_EMAIL_SUBJECT)
        ->setFrom(Config::SMTP_USER)
        ->setTo(Config::HC_EMAIL_TO)
        ->addPart($body, 'text/plain');

    if (!$mailer->send($email, $failures)) {
        echo "EMAIL FAIL! \n\n" . $body . "\n\n";
    }

    $transporter->stop();
    echo $body;

}

