<?php
mb_internal_encoding('UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée.');
}

// Récupération
$nom    = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email  = trim($_POST['email'] ?? '');
$objet  = trim($_POST['objet'] ?? '');
$message= trim($_POST['message'] ?? '');


if ($nom === '' || $prenom === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $objet === '' || $message === '') {
    header("Location: ../views/noscontacts.php?error=1");
    exit;
}


$to = 'athomecours@gmail.com';
$subject_plain = "Contact At Home Cours – $objet";
$subject = mb_encode_mimeheader($subject_plain, 'UTF-8');

// Corps du mail
$body  = "Message via le formulaire :\n\n";
$body .= "Nom       : $nom\n";
$body .= "Prénom    : $prenom\n";
$body .= "Email     : $email\n";
$body .= "Objet     : $objet\n";
$body .= "———————————————\n";
$body .= "$message\n";
$body = wordwrap($body, 998, "\r\n");


$from_email = 'noreply@athomecours.fr';
$from_name  = 'At Home Cours';

// En-têtes
$headers  = 'From: '.mb_encode_mimeheader($from_name, 'UTF-8').' <'.$from_email.'>'."\r\n";
$headers .= 'Reply-To: '.mb_encode_mimeheader("$prenom $nom", 'UTF-8')." <$email>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/".phpversion();

$ok = @mail($to, $subject, $body, $headers, '-f '.$from_email);


if ($ok) {
    header("Location: /../views/merciContact.php");
    exit;
} else {
    header("Location: /../views/noscontacts.php?error=2");
    exit;
}
