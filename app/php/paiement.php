<?php
require 'vendor/autoload.php'; // Stripe via Composer

Stripe::setApiKey('pk_test_51S8S5M08xGRnXNzGUGQKnUsmAhpmnwLmHjMcWfZXM8pAIjEw8d4RtGaCLVut7Ti25z6yH6a0A8idL7ZmFMWVv0XJ00dncIln0y');

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Cours à domicile - Séance 1h30',
            ],
            'unit_amount' => 3500,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/php/validepaiement.php',
    'cancel_url' => 'http://localhost/annule-paiement.php',
]);

header("Location: " . $checkout_session->url);
