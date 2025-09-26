<?php
require '../php/config.php';

/** @var PDO $pdo */

$token = $_GET['token'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND used = 0 LIMIT 1");
$stmt->execute([':token' => $token]);
$reset = $stmt->fetch();

if (!$reset || new DateTime() > new DateTime($reset['expiration'])) {
    exit("Lien invalide ou expiré.");
}
?>


    <form action="mdpreset.php" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" name="password" placeholder="Nouveau mot de passe" required>
        <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required>
        <button type="submit">Mettre à jour</button>
    </form>

