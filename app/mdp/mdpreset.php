<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../php/config.php";
require_once __DIR__ . "/../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/** @var PDO $pdo */

// 🔹 Récupère et valide l’email
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
if (!$email) {
    $_SESSION["error"] = "Adresse email invalide.";
    header("Location: /mdpoublie.php");
    exit;
}

// 🔹 Vérifie si l’email existe
$stmt = $pdo->prepare("
    SELECT email FROM eleves WHERE email=:email
    UNION
    SELECT email FROM professeurs WHERE email=:email
    UNION
    SELECT email FROM admins WHERE email=:email
");
$stmt->execute([":email" => $email]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION["error"] = "Aucun compte trouvé avec cet email.";
    header("Location: /mdpoublie.php");
    exit;
}

// 🔹 Génère le token
$token = bin2hex(random_bytes(32));
$token_hash = hash("sha256", $token);
$expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Supprime anciens tokens
$pdo->prepare("DELETE FROM password_resets WHERE email=:email")->execute([":email"=>$email]);

// Insert nouveau token
$stmt = $pdo->prepare("
    INSERT INTO password_resets (email, token, expiration)
    VALUES (:email, :token, :exp)
");
$stmt->execute([":email"=>$email, ":token"=>$token_hash, ":exp"=>$expire]);

// 🔹 Lien reset
$baseUrl = "http://localhost:8080/app";
$resetLink = "$baseUrl/mdp/mdp.php?token=$token&email=" . urlencode($email);

// 🔹 Envoi mail via Mailhog
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'mailhog';
    $mail->Port = 1025;
    $mail->SMTPAuth = false;

    $mail->setFrom('no-reply@athomecours.local', 'At Home Cours');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Réinitialisation de votre mot de passe";
    $mail->Body = "
        <p>Bonjour,cher(e) membre de AT HOME COURS</p>
        <p>Vous avez demandé à réinitialiser votre mot de passe .</p>
        <p><a href='$resetLink'>Cliquez ici pour le réinitialiser</a></p>
        <p>Ce lien expirera dans 1 heure.</p>
    ";

    $mail->send();
    $_SESSION["success"] = "Un email de réinitialisation a été envoyé.";
} catch (Exception $e) {
    error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
    $_SESSION["error"] = "Impossible d'envoyer l'email. Contactez l'administrateur.";
}

// 🔹 Redirection finale (aucun echo avant ça !)
header("Location: ../mdp/mdpoublie.php");
exit;
