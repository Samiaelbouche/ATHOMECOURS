<?php

session_start();
require_once __DIR__ . "/config.php";


/** @var PDO $pdo */


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_BCRYPT);
    $date_naissance = !empty($_POST["date_naissance"]) ? $_POST["date_naissance"] : null;
    $adresse = !empty($_POST["adresse"]) ? $_POST["adresse"] : null;
    $ville = !empty($_POST["ville"]) ? $_POST["ville"] : null;
    $code_postal = !empty($_POST["code_postal"]) ? $_POST["code_postal"] : null;
    $telephone = !empty($_POST["telephone"]) ? $_POST["telephone"] : null;
    $niveau_scolaire = $_POST["niveau_scolaire"];
    $classe = !empty($_POST["classe"]) ? $_POST["classe"] : null;
    $etablissement = !empty($_POST["etablissement"]) ? $_POST["etablissement"] : null;
    $nom_parent = !empty($_POST["nom_parent"]) ? $_POST["nom_parent"] : null;
    $telephone_parent = !empty($_POST["telephone_parent"]) ? $_POST["telephone_parent"] : null;
    $email_parent = !empty($_POST["email_parent"]) ? $_POST["email_parent"] : null;
    $besoins_particuliers = !empty($_POST["besoins_particuliers"]) ? $_POST["besoins_particuliers"] : null;


    $sql = "INSERT INTO eleves 
            (nom, prenom, email, mot_de_passe, date_naissance, adresse, ville, code_postal, telephone, niveau_scolaire, classe, etablissement, nom_parent, telephone_parent, email_parent, besoins_particuliers) 
            VALUES 
            (:nom, :prenom, :email, :mot_de_passe, :date_naissance, :adresse, :ville, :code_postal, :telephone, :niveau_scolaire, :classe, :etablissement, :nom_parent, :telephone_parent, :email_parent, :besoins_particuliers)";

    $stmt = $pdo->prepare($sql);



    try {
        $check = $pdo->prepare("SELECT id FROM eleves WHERE email = :email");
        $check->execute([":email" => $email]);
        if ($check->fetch()) {
            $_SESSION["error"] = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
            header("Location: ../views/inscriptioneleveview.php");
            exit;
        }


        $sql = "INSERT INTO eleves 
                (nom, prenom, email, mot_de_passe, date_naissance, adresse, ville, code_postal, telephone, niveau_scolaire, classe, etablissement, nom_parent, telephone_parent, email_parent, besoins_particuliers) 
                VALUES 
                (:nom, :prenom, :email, :mot_de_passe, :date_naissance, :adresse, :ville, :code_postal, :telephone, :niveau_scolaire, :classe, :etablissement, :nom_parent, :telephone_parent, :email_parent, :besoins_particuliers)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":email" => $email,
            ":mot_de_passe" => $mot_de_passe,
            ":date_naissance" => $date_naissance,
            ":adresse" => $adresse,
            ":ville" => $ville,
            ":code_postal" => $code_postal,
            ":telephone" => $telephone,
            ":niveau_scolaire" => $niveau_scolaire,
            ":classe" => $classe,
            ":etablissement" => $etablissement,
            ":nom_parent" => $nom_parent,
            ":telephone_parent" => $telephone_parent,
            ":email_parent" => $email_parent,
            ":besoins_particuliers" => $besoins_particuliers
        ]);

        $_SESSION["success"] = "Inscription élève réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: ../views/connexionView.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION["error"] = "Erreur lors de l'inscription : " . $e->getMessage();
        header("Location: ../views/inscriptioneleveview.php");
        exit;
    }
}