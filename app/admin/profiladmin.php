<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../php/config.php';


if (empty($_SESSION['user_id']) || (($_SESSION['role'] ?? '') !== 'admin')) {
    header("Location: ../views/connexionView.php");
    exit;
}

/** @var PDO $pdo */



$totalEleves = (int) $pdo->query("SELECT COUNT(*) FROM eleves WHERE statut = 'valide'")->fetchColumn();

$totalProfs  = (int) $pdo->query("SELECT COUNT(*) FROM professeurs WHERE statut = 'valide'")->fetchColumn();

$totalCours  = (int) $pdo->query("SELECT COUNT(*) FROM cours")->fetchColumn();

$coursConf   = (int) $pdo->query("SELECT COUNT(*) FROM cours WHERE statut = 'confirme'")->fetchColumn();

$coursAnn    = (int) $pdo->query("SELECT COUNT(*) FROM cours WHERE statut = 'annule'")->fetchColumn();


$attentesProfs = $pdo->query("
    SELECT id, prenom, nom, email
    FROM professeurs
    WHERE statut = 'en_attente'
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);


$attentesEleves = $pdo->query("
    SELECT id, prenom, nom, email
    FROM eleves
    WHERE statut = 'en_attente'
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);


$stats = [
    'totalEleves' => $totalEleves,
    'totalProfs'  => $totalProfs,
    'totalCours'  => $totalCours,
    'coursConf'   => $coursConf,
    'coursAnn'    => $coursAnn,
];


require __DIR__ .  '/profilAdminView.php';