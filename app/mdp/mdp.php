<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../php/config.php";

/** @var PDO $pdo */

// Récupération des paramètres GET
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if (!$token || !$email) {
    exit("Lien invalide.");
}

// On calcule le hash du token reçu
$token_hash = hash("sha256", $token);

// Vérification dans la base
$stmt = $pdo->prepare("
    SELECT * FROM password_resets 
    WHERE email = :email AND token = :token AND used = 0 
    LIMIT 1
");
$stmt->execute([
    ":email" => $email,
    ":token" => $token_hash
]);
$reset = $stmt->fetch();

if (!$reset) {
    exit("Lien invalide.");
}

// Vérifie si le lien a expiré
if (new DateTime() > new DateTime($reset["expiration"])) {
    exit("Lien expiré.");
}

$template = __DIR__ . '/../partial/mdpmajContent.php';


include __DIR__ . '/../partial/layout.php';


