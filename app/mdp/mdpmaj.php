<?php
require '../php/config.php';

/** @var PDO $pdo */

$token = $_POST['token'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (!$token || !$email) exit("Lien invalide.");
if ($password !== $password_confirm) exit("Les mots de passe ne correspondent pas.");

$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE email = :email AND used = 0 LIMIT 1");
$stmt->execute([':email' => $email]);
$reset = $stmt->fetch();

if (!$reset || new DateTime() > new DateTime($reset['expiration'])) {
    exit("Lien invalide ou expiré.");
}

if (!hash_equals($reset['token'], hash('sha256', $token))) {
    exit("Lien invalide.");
}

// Hash mot de passe
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Mise à jour dans élèves / profs / admins
$tables = ['eleves', 'professeurs', 'admins'];
$updated = false;
foreach ($tables as $table) {
    $stmt = $pdo->prepare("UPDATE $table SET mot_de_passe = :pwd WHERE email = :email");
    $stmt->execute([':pwd' => $hashed, ':email' => $email]);
    if ($stmt->rowCount()) {
        $updated = true;
        break;
    }
}

if ($updated) {
    $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE email = :email");
    $stmt->execute([':email' => $email]);

    // Redirection vers la page connexion
    header("Location: ../php/connexion.php?reset=success");
    exit;
} else {
    header("Location: ../php/connexion.php?reset=error");
    exit;
}