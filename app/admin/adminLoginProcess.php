<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../php/config.php';

/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);


    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
    $stmt->execute([":email" => $email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($mot_de_passe, $admin["mot_de_passe"])) {
        $_SESSION["user_id"]     = $admin["id"];
        $_SESSION["user_nom"]    = $admin["nom"];
        $_SESSION["user_prenom"] = $admin["prenom"];
        $_SESSION["role"]        = "admin";
        $_SESSION["user_email"]  = $admin["email"];
        $_SESSION["success"]     = "Connexion réussie ! Bienvenue {$admin['prenom']} ";

        header("Location: profilAdmin.php");
        exit;
    } else {
        $_SESSION["error"] = "Email ou mot de passe incorrect.";
        header("Location: admin_connexion.php");
        exit;
    }
}