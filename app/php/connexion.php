<?php
session_start();

require_once __DIR__ . "/config.php";


/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim(htmlspecialchars($_POST["email"]));
    $mot_de_passe = trim($_POST["mot_de_passe"]);
    $role = trim($_POST["role"]);

    $roles = [
        "eleve" => ["table" => "eleves", "redirect" => "../php/profileleve.php"],
        "professeur" => ["table" => "professeurs", "redirect" => "../php/profilprof.php"],

    ];

    if (!isset($roles[$role])) {
        $_SESSION["error"] = "Rôle non reconnu !";
        header("Location: ../views/connexionView.php");
        exit;
    }

    $sql = "SELECT * FROM {$roles[$role]['table']} WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($mot_de_passe, $user["mot_de_passe"])) {
            if ($role !== "admin" && ($user["statut"] ?? '') !== "valide") {
                $_SESSION["error"] = "Votre compte est en attente de validation par l'administrateur.";
                header("Location: ../php/connexion.php");
                exit;
            }


            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_nom"] = $user["nom"];
            $_SESSION["user_prenom"] = $user["prenom"];
            $_SESSION["role"] = $role;
            $_SESSION["user_email"] = $user["email"] ?? null;



            header("Location: {$roles[$role]['redirect']}");
            exit;
        } else {
            $_SESSION["error"] = "Mot de passe incorrect.";
            header("Location: ../views/connexionView.php");
            exit;
        }
    } else {
        $_SESSION["error"] = "Email introuvable pour le rôle sélectionné.";
        header("Location: ../views/connexionView.php");
        exit;
    }
}



