<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']) || str_contains($_SERVER['SERVER_NAME'], 'docker');

// Récupération des données
$nom     = trim($_POST['nom'] ?? '');
$prenom  = trim($_POST['prenom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$objet   = trim($_POST['objet'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($nom === '' || $prenom === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $objet === '' || $message === '') {
    header("Location: ../views/noscontacts.php?error=1");
    exit;
}

if ($isLocal) {

    $to       = "athomecours@gmail.com";
    $subject  = "Contact At Home Cours – $objet";
    $body     = "Nom : $nom\nPrénom : $prenom\nEmail : $email\nObjet : $objet\n\n$message";
    $headers  = "From: At Home Cours <contact@athomecours.fr>\r\n";
    $headers .= "Reply-To: $prenom $nom <$email>\r\n";

    $ok = mail($to, $subject, $body, $headers);

    if ($ok) {
        header("Location: ../views/merciContact.php");
        exit;
    } else {
        header("Location: ../views/noscontacts.php?error=2");
        exit;
    }

} else {

    $mail = new PHPMailer(true);

    try {
        // Config SMTP (exemple OVH)
        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@athomecours.fr';
        $mail->Password   = 'MOT_DE_PASSE';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Expéditeur
        $mail->setFrom('contact@athomecours.fr', 'At Home Cours');

        // Destinataire
        $mail->addAddress('athomecours@gmail.com', 'At Home Cours');

        // Répondre à
        $mail->addReplyTo($email, "$prenom $nom");

        // Contenu
        $mail->isHTML(false);
        $mail->Subject = "Contact – $objet";
        $mail->Body    = "Nom: $nom\nPrénom: $prenom\nEmail: $email\n\nMessage:\n$message";

        $mail->send();

        header("Location: ../views/merciContact.php");
        exit;

    } catch (Exception $e) {
        // En dev tu peux debug ici
        // echo "Erreur d'envoi: {$mail->ErrorInfo}";
        header("Location: ../views/noscontacts.php?error=2");
        exit;
    }
}