<?php

require '../php/config.php';

/** @var PDO $pdo */


$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if ($password !== $password_confirm) {
    exit("Les mots de passe ne correspondent pas.");
}

$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND used = 0 LIMIT 1");
$stmt->execute([':token' => $token]);
$reset = $stmt->fetch();

if (!$reset || new DateTime() > new DateTime($reset['expiration'])) {
    exit("Lien invalide ou expiré.");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$email = $reset['email'];


$tables = ['eleves', 'professeurs'];
foreach ($tables as $table) {
    $stmt = $pdo->prepare("UPDATE $table SET mot_de_passe = :pwd WHERE email = :email");
    $stmt->execute([':pwd' => $hashed, ':email' => $email]);
    if ($stmt->rowCount()) {
        break;
    }
}


$stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = :token");
$stmt->execute([':token' => $token]);

echo "Mot de passe mis à jour. Vous pouvez maintenant vous connecter.";
