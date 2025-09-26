<?php


require_once __DIR__ . "/config.php";
/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_BCRYPT); // sécurité
    $date_naissance = !empty($_POST["date_naissance"]) ? $_POST["date_naissance"] : null;
    $adresse = !empty($_POST["adresse"]) ? $_POST["adresse"] : null;
    $ville = !empty($_POST["ville"]) ? $_POST["ville"] : null;
    $code_postal = !empty($_POST["code_postal"]) ? $_POST["code_postal"] : null;
    $telephone = !empty($_POST["telephone"]) ? $_POST["telephone"] : null;
    $diplome = !empty($_POST["diplome"]) ? $_POST["diplome"] : null;
    $experience_annees = !empty($_POST["experience_annees"]) ? intval($_POST["experience_annees"]) : 0;
    $disponibilites = !empty($_POST["disponibilites"]) ? $_POST["disponibilites"] : null;
    $motivation = !empty($_POST["motivation"]) ? $_POST["motivation"] : null;


    $cv_url = null;
    if (!empty($_FILES["cv"]["name"])) {
        $targetDir = "uploads/cv_professeurs/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES["cv"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFile)) {
            $cv_url = $targetFile;
        }
    }





    $sql = "INSERT INTO professeurs 
            (nom, prenom, email, mot_de_passe, date_naissance, adresse, ville, code_postal, telephone, diplome, experience_annees, disponibilites, motivation, cv_url) 
            VALUES 
            (:nom, :prenom, :email, :mot_de_passe, :date_naissance, :adresse, :ville, :code_postal, :telephone, :diplome, :experience_annees, :disponibilites, :motivation, :cv_url)";

    $stmt = $pdo->prepare($sql);

    try {
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
            ":diplome" => $diplome,
            ":experience_annees" => $experience_annees,
            ":disponibilites" => $disponibilites,
            ":motivation" => $motivation,
            ":cv_url" => $cv_url
        ]);

        $_SESSION["success"] = "Inscription professeure réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: ../views/connexionView.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION["error"] = "Erreur lors de l'inscription : " . $e->getMessage();
        header("Location: ../views/inscriptionProfview.php");
        exit;}

    }


