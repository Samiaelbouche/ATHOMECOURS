<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/config.php";

/** @var PDO $pdo */

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Adresse email invalide.";
        header("Location: ../php/mdpoublie.php");
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
        header("Location: ../php/mdpoublie.php");
        exit;
    }


    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));


    $stmt = $pdo->prepare("
        INSERT INTO password_resets (email, token, expiration)
        VALUES (:email, :token, :exp)
    ");
    $stmt->execute([":email"=>$email, ":token"=>$token, ":exp"=>$expire]);


    $resetLink = "http://localhost/php/reset_password.php?token=" . $token;

    $_SESSION["success"] = "Un lien de réinitialisation a été généré : $resetLink";
    header("Location: ../php/mdpoublie.php");
    exit;
    }  ?>
    <!doctype html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Mot de passe oublié</title>
            </head>
            <?php include '../partial/header.php'; ?>
            <body>
            <h1>Mot de passe oublié</h1>

            <?php if ($error): ?>
                <p ><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p ><?= $success ?></p>
            <?php endif; ?>

            <form method="post" action="../php/mdpoublie.php">
                <label for="email">Votre email :</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <button type="submit">Réinitialiser</button>
            </form>

            <p><a href="../view/connexionView.php">Retour à la connexion</a></p>
            <?php include '../partial/footer.php'; ?>
