<?php include '../partial/header.php'; ?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]); // on vide après affichage
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>


</head>
<body>
    <h1> se connecter </h1>

        <div class="container">
            <h1> CONNEXION: </h1>

                <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form action="../php/connexion.php" method="post">
                <label for="role">Je suis :</label>
                <select id="role" name="role" required>
                    <option value="eleve">Élève</option>
                    <option value="professeur">Professeur</option>
                    <option value="admin">Administrateur</option>
                </select>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit">Se connecter</button>
            </form>
        </div>

        <p class="forgot"><a href="../php/mdp.php">Mot de passe oublié ?</a></p>




</body>
<?php include '../partial/footer.php'; ?>