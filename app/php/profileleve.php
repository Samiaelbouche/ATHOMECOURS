<?php

session_start();
require_once __DIR__ . "/config.php";


/** @var PDO $pdo */


if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'eleves') {
    header("Location: login.php");
    exit;
}

$eleveId = (int)$_SESSION['user_id'];

// Récup infos élève
$stmt = $pdo->prepare("SELECT nom, prenom, email FROM eleves WHERE id = :id");
$stmt->execute([":id" => $eleveId]);
$eleve = $stmt->fetch(PDO::FETCH_ASSOC);

$msg = "";

/* ------------------- RÉSERVATION D’UN COURS ------------------- */
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "reserver") {
    $dispoId     = (int)$_POST["dispo_id"];
    $dateChoisie = $_POST["date_cours"] ?? '';
    $lieu        = $_POST["lieu"] ?? 'en_ligne';
    $adresse     = $_POST["adresse_cours"] ?? null;

    // Vérifier disponibilité choisie
    $stmt = $pdo->prepare("
        SELECT d.id, d.professeur_id, d.heure_debut,
               p.nom, p.prenom
        FROM disponibilites_prof d
        JOIN professeurs p ON p.id = d.professeur_id
        WHERE d.id = :id AND d.actif = 1
    ");
    $stmt->execute([":id" => $dispoId]);
    $dispo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dispo && $dateChoisie) {

        $dateCours = $dateChoisie . " " . $dispo["heure_debut"];


        $stmt = $pdo->prepare("
            INSERT INTO cours (eleve_id, professeur_id, date_cours, duree_minutes, lieu, adresse_cours, statut)
            VALUES (:eid, :pid, :dc, 90, :lieu, :adr, 'planifie')
        ");
        $stmt->execute([
            ":eid"  => $eleveId,
            ":pid"  => $dispo["professeur_id"],
            ":dc"   => $dateCours,
            ":lieu" => $lieu,
            ":adr"  => $adresse
        ]);

        $msg = " Cours réservé avec " . htmlspecialchars($dispo["prenom"] . " " . $dispo["nom"]) .
            " le " . date("d/m/Y H:i", strtotime($dateCours));
    } else {
        $msg = " Créneau invalide.";
    }
}

$dispos = $pdo->query("
    SELECT d.id, d.jour_semaine, d.heure_debut, d.heure_fin,
           p.nom, p.prenom
    FROM disponibilites_prof d
    JOIN professeurs p ON p.id = d.professeur_id
    WHERE d.actif = 1
    ORDER BY FIELD(d.jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'),
             d.heure_debut
")->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("
    SELECT c.date_cours, c.duree_minutes, c.lieu, c.adresse_cours, c.statut, c.notes_cours,
           p.nom AS nom_prof, p.prenom AS prenom_prof
    FROM cours c
    JOIN professeurs p ON p.id = c.professeur_id
    WHERE c.eleve_id = :eid
    ORDER BY c.date_cours ASC
");
$stmt->execute([":eid" => $eleveId]);
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);