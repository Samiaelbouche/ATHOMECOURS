<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/config.php";

/** @var PDO $pdo */

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);

$token = $_GET["token"] ?? null;
if (!$token) {
    die("Lien invalide.");
}


$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token=:t AND used=0 LIMIT 1");
$stmt->execute([":t"=>$token]);
$row = $stmt->fetch();

if (!$row || strtotime($row["expiration"]) < time()) {
    die(" Lien expiré ou invalide.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPass = $_POST["mot_de_passe"];
    $confirm = $_POST["confirme"];

    if ($newPass !== $confirm) {
        $_SESSION["error"] = "Les mots de passe ne correspondent pas.";
        header("Location: ../php/resetmdp.php?token=" . urlencode($token));
        exit;
    }

    $hash = password_hash($newPass, PASSWORD_DEFAULT);


    $stmt = $pdo->prepare("UPDATE eleves SET mot_de_passe=:mp WHERE email=:email");
    $stmt->execute([":mp"=>$hash, ":email"=>$row["email"]]);


    $stmt = $pdo->prepare("UPDATE professeurs SET mot_de_passe=:mp WHERE email=:email");
    $stmt->execute([":mp"=>$hash, ":email"=>$row["email"]]);


    $stmt = $pdo->prepare("UPDATE password_resets SET used=1 WHERE id=:id");
    $stmt->execute([":id"=>$row["id"]]);

    $_SESSION["success"] = "Mot de passe mis à jour. Vous pouvez vous connecter.";
    header("Location: ../php/connexion.php");
    exit;
}
?>
    <!doctype html>
    <html lang="fr">
    <head><meta charset="UTF-8"><title>Réinitialiser</title></head>
        <body>
        <h1>Réinitialiser le mot de passe</h1>
        <?php if ($error): ?><p><?= htmlspecialchars($error) ?></p><?php endif; ?>

            <form method="post">
                <label>Nouveau mot de passe :</label><br>
                <input type="password" name="mot_de_passe" required><br><br>
                <label>Confirmer :</label><br>
                <input type="password" name="confirme" required><br><br>
                <button type="submit">Réinitialiser</button>
            </form>
        </body>
    </html>