<?php
require '../php/config.php';

/** @var PDO $pdo */

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    exit("Email invalide.");
}


$tables = ['eleves', 'professeurs'];
$found = false;
foreach ($tables as $table) {
    $stmt = $pdo->prepare("SELECT id FROM $table WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $found = true;
        break;
    }
}

if ($found) {
    $token = bin2hex(random_bytes(32));
    $expiration = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expiration) VALUES (:email, :token, :expiration)");
    $stmt->execute([
        ':email' => $email,
        ':token' => $token,
        ':expiration' => $expiration
    ]);

    $resetLink = "http://localhost/mdpreset.php?token=$token";

    mail($email, "Réinitialisation mot de passe",
        "Cliquez sur ce lien pour réinitialiser : $resetLink");
}

echo "Si cet email existe, un lien de réinitialisation a été envoyé.";
