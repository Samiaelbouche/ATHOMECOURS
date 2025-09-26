<?php
session_start();
require_once __DIR__ . "/../php/config.php";

/** @var PDO $pdo */

$paiementId = (int)($_GET['paiement_id'] ?? 0);
if (!$paiementId) {
    die("Aucun paiement spécifié.");
}


$stmt = $pdo->prepare("SELECT * FROM paiements WHERE id = :id");
$stmt->execute([":id" => $paiementId]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    die("Paiement introuvable.");
}


$updatePaiement = $pdo->prepare("UPDATE paiements SET status = 'confirme' WHERE id = :id");
$updatePaiement->execute([":id" => $paiementId]);

$eleveId   = $paiement['eleve_id'];
$type      = $paiement['type'];
$mode      = $paiement['mode'];
$dateDebut = $paiement['date_debut'];
$dateFin   = $paiement['date_fin'];

if ($type === "unite") {
    $sql = "UPDATE cours 
            SET statut = 'confirme', paiement_id = :paiement_id
            WHERE eleve_id = :eleve_id 
              AND paiement_id IS NULL 
              AND lieu = :lieu
            ORDER BY date_cours ASC
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":paiement_id" => $paiementId,
        ":eleve_id" => $eleveId,
        ":lieu" => ($mode === "en_ligne") ? "en_ligne" : "domicile_eleve"
    ]);

} elseif ($type === "forfait") {
    $sql = "UPDATE cours 
            SET statut = 'confirme', paiement_id = :paiement_id
            WHERE eleve_id = :eleve_id
              AND lieu = :lieu
              AND DATE(date_cours) BETWEEN :date_debut AND :date_fin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":paiement_id" => $paiementId,
        ":eleve_id" => $eleveId,
        ":lieu" => ($mode === "en_ligne") ? "en_ligne" : "domicile_eleve",
        ":date_debut" => $dateDebut,
        ":date_fin" => $dateFin
    ]);
}

echo "Paiement confirmé et cours mis à jour.";