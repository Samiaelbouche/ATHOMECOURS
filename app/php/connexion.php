<?php

session_start();
require_once __DIR__ . "/config.php";


/** @var PDO $pdo */


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $mot_de_passe = $_POST["mot_de_passe"];
    $role = $_POST["role"];


    $sql = "SELECT * FROM eleves WHERE email = :email
    UNION 
    SELECT * FROM professeurs WHERE email = :email
    LIMIT 1";



    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($mot_de_passe, $user["mot_de_passe"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_nom"] = $user["nom"];
            $_SESSION["user_prenom"] = $user["prenom"];
            $_SESSION["role"] = $role;

            header('Location: /php/home.php');
            exit;

        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Email introuvable pour le rôle sélectionné.";
    }

    if (isset($error)) {
        echo "<p> " . $error . "</p>";
    }


}

include_once "../html/connexion.html";