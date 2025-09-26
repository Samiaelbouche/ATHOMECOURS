<?php
require '../../vendor/autoload.php';
require_once __DIR__ . '/../php/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/** @var PDO $pdo */
// Vérifier que l’utilisateur est connecté et est un élève
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'eleve') {
    header("Location: ../views/login.php?error=connexion_requise");
    exit;
}

$eleveId = (int)$_SESSION['user_id'];
$coursId = (int)($_GET['cours_id'] ?? 0);

// Vérifier que le cours existe
$stmt = $pdo->prepare("SELECT * FROM cours WHERE id = :id");
$stmt->execute([':id' => $coursId]);
$cours = $stmt->fetch();

if (!$cours) {
    die("Erreur : cours introuvable.");
}

$label        = "Cours de physique-chimie (" . $cours['lieu'] . ")";
$amount       = (int) round((float)$cours['prix'] * 100); // centimes
$typePaiement = $cours['type_paiement'];                  // 'unite' / 'forfait'
$modePaiement = $cours['lieu'];                           // 'en_ligne' / 'domicile'

if ($amount <= 0) {
    $amount = ($cours['lieu'] === 'en_ligne') ? 3000 : 3500;
}
// Créer la session Stripe
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $label,
            ],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'metadata' => [
        'cours_id'      => $coursId,
        'eleve_id'      => $eleveId,
        'type_paiement' => $typePaiement,
        'mode_paiement' => $modePaiement,
    ],
    'success_url' => 'http://localhost:8080/app/paiement/validepaiement.php',
    'cancel_url'  => 'http://localhost:8080/app/paiement/cancel.php',
]);

// Redirige vers Stripe Checkout
header("Location: " . $session->url);
exit;