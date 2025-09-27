<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);
?>

<div class="mdp-oublie">
    <h2>Mot de passe </h2>

    <?php if ($error): ?>
        <p class="mdp-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="mdp-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form action="../mdp/mdpreset.php" method="post" class="mdp-form">
        <label for="email">Adresse e-mail</label>
        <input type="email" name="email" placeholder="Votre email" required>
        <button type="submit">Réinitialiser mon mot de passe</button>
    </form>

    <p class="mdp-back">
        <a href="../php/connexion.php">Retour à la connexion</a>
    </p>
</div>


