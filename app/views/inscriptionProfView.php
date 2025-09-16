<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>

</head>
<body>
<h1>Je suis professeur </h1>
<?php if ($error): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form action="../php/inscriptionprof.php" method="post" enctype="multipart/form-data">
    <h2>Inscription d’un professeur</h2>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required><br><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

    <label for="date_naissance">Date de naissance :</label>
    <input type="date" id="date_naissance" name="date_naissance"><br><br>

    <label for="adresse">Adresse :</label>
    <textarea id="adresse" name="adresse"></textarea><br><br>

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville"><br><br>

    <label for="code_postal">Code postal :</label>
    <input type="text" id="code_postal" name="code_postal" maxlength="5"><br><br>

    <label for="telephone">Téléphone :</label>
    <input type="tel" id="telephone" name="telephone"><br><br>

    <label for="diplome">Diplôme :</label>
    <input type="text" id="diplome" name="diplome"><br><br>

    <label for="experience_annees">Années d’expérience :</label>
    <input type="number" id="experience_annees" name="experience_annees" min="0"><br><br>

    <label for="disponibilites">Disponibilités :</label>
    <textarea id="disponibilites" name="disponibilites"></textarea><br><br>

    <label for="motivation">Motivation :</label>
    <textarea id="motivation" name="motivation"></textarea><br><br>

    <label for="cv">CV (lien ou fichier) :</label>
    <input type="file" id="cv" name="cv"><br><br>

    <button type="submit">S’inscrire</button>
</form>

</body>
</html>

