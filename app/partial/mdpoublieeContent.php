<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../php/config.php";

/** @var PDO $pdo */

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Adresse email invalide.";
        header("Location: /mdpoublie.php");
        exit;
    }


    $stmt = $pdo->prepare("
        SELECT email FROM eleves WHERE email=:email
        UNION
        SELECT email FROM professeurs WHERE email=:email
    ");
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION["error"] = "Aucun compte trouvé avec cet email.";
        header("Location: /mdpoublie.php");
        exit;
    }


    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));


    $stmt = $pdo->prepare("
        INSERT INTO password_resets (email, token, expiration)
        VALUES (:email, :token, :exp)
    ");
    $stmt->execute([":email"=>$email, ":token"=>$token, ":exp"=>$expire]);


    $resetLink = "http://localhost/php/mdp.php?token=" . $token;

    $_SESSION["success"] = "Un lien de réinitialisation a été généré : $resetLink";
    header("Location: /mdpoublie.php");
    exit;
}  ?>


    <div class="mdp-oublie">
        <h2>Mot de passe </h2>

        <?php if ($error): ?>
            <p class="mdp-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="mdp-success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form  action="../mdp/mdpreset.php" method="post" class="mdp-form">
            <input type="email" name="email" placeholder="Votre email" required>
            <button type="submit">Réinitialiser mon mot de passe</button>
        </form>

        <p class="mdp-back">
            <a href="../php/connexion.php">Retour à la connexion</a>
        </p>
    </div>

