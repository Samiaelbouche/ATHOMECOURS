<?php

session_start();
require_once __DIR__ . "/config.php";

/** @var PDO $pdo */

if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'professeur') {
    header("Location: php/connexion.php");
    exit;
}
$profId = (int)$_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT nom, prenom, email FROM professeurs WHERE id = :id");
$stmt->execute([":id"=>$profId]);
$prof = $stmt->fetch(PDO::FETCH_ASSOC);


$msg = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "add") {
    $jour = $_POST["jour_semaine"] ?? "";
    $debut = $_POST["heure_debut"] ?? "";
    $fin   = $_POST["heure_fin"] ?? "";

    if ($jour && $debut && $fin && $fin > $debut) {
        $pdo->prepare("
            INSERT INTO disponibilites_prof (professeur_id, jour_semaine, heure_debut, heure_fin)
            VALUES (:pid,:j,:hd,:hf)
        ")->execute([":pid"=>$profId,":j"=>$jour,":hd"=>$debut,":hf"=>$fin]);
        $msg = "Disponibilité ajoutée ";
    } else $msg = "Erreur dans le formulaire ";
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "toggle") {
    $id = (int)$_POST["id"];
    $pdo->prepare("UPDATE disponibilites_prof SET actif = NOT actif WHERE id=:id AND professeur_id=:pid")
        ->execute([":id"=>$id, ":pid"=>$profId]);
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "delete") {
    $id = (int)$_POST["id"];
    $pdo->prepare("DELETE FROM disponibilites_prof WHERE id=:id AND professeur_id=:pid")
        ->execute([":id"=>$id, ":pid"=>$profId]);
}


$stmt = $pdo->prepare("SELECT * FROM disponibilites_prof WHERE professeur_id=:pid ORDER BY FIELD(jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'), heure_debut");
$stmt->execute([":pid"=>$profId]);
$dispos = $stmt->fetchAll(PDO::FETCH_ASSOC);



include_once "../html/profilprof.html";


