<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'])
    || str_contains($_SERVER['SERVER_NAME'], 'docker');

// Récupération des données du formulaire
$nom     = trim($_POST['nom'] ?? '');
$prenom  = trim($_POST['prenom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$objet   = trim($_POST['objet'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation basique
if ($nom === '' || $prenom === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $objet === '' || $message === '') {
    header("Location: ../views/contact.php?error=1");
    exit;
}

$mail = new PHPMailer(true);

try {
    if ($isLocal) {

        $mail->isSMTP();
        $mail->Host       = 'mailhog';
        $mail->Port       = 1025;
        $mail->SMTPAuth   = false;
    } else {
        // --- CONFIG PROD : OVH ---
        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@athomecours.fr';
        $mail->Password   = 'MOT_DE_PASSE';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    }

    // Expéditeur
    $mail->setFrom('contact@athomecours.fr', 'At Home Cours');

    // Destinataire
    $mail->addAddress('athomecours@gmail.com', 'At Home Cours');

    // Adresse de réponse
    $mail->addReplyTo($email, "$prenom $nom");

    // Contenu
    $mail->isHTML(false);
    $mail->Subject = "Contact – $objet";
    $mail->Body    = "Nom: $nom\nPrénom: $prenom\nEmail: $email\n\nMessage:\n$message";

    $mail->send();

    header("Location: ../views/merciContact.php");
    exit;

} catch (Exception $e) {
    if ($isLocal) {

        echo "<h2>Erreur PHPMailer</h2>";
        echo "<pre>{$mail->ErrorInfo}</pre>";
        exit;
    } else {

        header("Location: ../views/contact.php?error=2");
        exit;
    }
}