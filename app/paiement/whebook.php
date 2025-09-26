<?php
require '../../vendor/autoload.php';
require_once __DIR__ . '/../php/config.php';

/** @var PDO $pdo */

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
$endpoint_secret = $_ENV['STRIPE_WEBHOOK_SECRET'] ?? null;

$payload    = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$event      = null;

try {
    // Vérifier la signature Stripe
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // JSON invalide
    http_response_code(400);
    exit("⚠️ Invalid payload");
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Signature invalide
    http_response_code(400);
    exit("⚠️ Invalid signature");
}

if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;

    if ($session->payment_status === 'paid') {
        // Récupérer les métadonnées
        $coursId      = $session->metadata->cours_id ?? null;
        $eleveId      = $session->metadata->eleve_id ?? null;
        $typePaiement = $session->metadata->type_paiement ?? 'unite';
        $modePaiement = $session->metadata->mode_paiement ?? 'en_ligne';

        if ($coursId && $eleveId) {
            // Enregistrer le paiement
            $stmt = $pdo->prepare("INSERT INTO paiements 
                (eleve_id, montant, type, mode, status, stripe_session_id) 
                VALUES (:eleve_id, :montant, :type_paiement, :mode_paiement, 'confirme', :session_id)");
            $stmt->execute([
                ":eleve_id"      => $eleveId,
                ":montant"       => $session->amount_total / 100,
                ":type_paiement" => $typePaiement,
                ":mode_paiement" => $modePaiement,
                ":session_id"    => $session->id
            ]);
            $paiementId = $pdo->lastInsertId();

            // Mettre à jour le cours lié
            $update = $pdo->prepare("UPDATE cours 
                SET statut = 'confirme', paiement_id = :pid 
                WHERE id = :coursId");
            $update->execute([
                ":pid"     => $paiementId,
                ":coursId" => $coursId
            ]);
        }
    }
} elseif ($event->type === 'checkout.session.expired') {
    $session = $event->data->object;
    $coursId = $session->metadata->cours_id ?? null;

    if ($coursId) {
        // Marquer le cours comme échoué/annulé
        $update = $pdo->prepare("UPDATE cours 
            SET statut = 'annule' 
            WHERE id = :coursId");
        $update->execute([":coursId" => $coursId]);
    }
}

// Toujours répondre 200 à Stripe
http_response_code(200);
echo "✅ Webhook reçu";