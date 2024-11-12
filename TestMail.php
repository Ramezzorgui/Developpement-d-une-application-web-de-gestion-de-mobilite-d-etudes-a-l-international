<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Utilisez TLS avec le port 587
$transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
$transport->setUsername('ramez.zorgui74@gmail.com');
$transport->setPassword('ramez123');

$mailer = new Mailer($transport);

$email = (new Email())
    ->from('ramez.zorgui74@gmail.com')
    ->to('hammaossa74@gmail.com')
    ->subject('Test Email')
    ->text('This is a test email.');

try {
    $mailer->send($email);
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Failed to send email: " . $e->getMessage();
}
