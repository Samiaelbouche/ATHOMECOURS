<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../php/config.php';

/** @var PDO $pdo */


if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /../php/connexion.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int) ($_POST['id'] ?? 0);
    $type   = $_POST['type'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($id > 0 && in_array($type, ['eleve','professeur']) && in_array($action, ['valide','refuse'])) {
        $table = ($type === 'eleve') ? 'eleves' : 'professeurs';
        $newStatut = ($action === 'valide') ? 'valide' : 'refuse';

        $stmt = $pdo->prepare("UPDATE $table SET statut = ? WHERE id = ?");
        $stmt->execute([$newStatut, $id]);
    }
}


header("Location: ../admin/profiladmin.php");
exit;