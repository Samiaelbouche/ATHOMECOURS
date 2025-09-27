<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);
?>


<?php if ($error): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

        <form  class="formprof" action="../php/inscriptionprof.php" method="post" enctype="multipart/form-data">
            <h2>Inscription professeur(e)</h2>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="password" name="mot_de_passe" required>

            <input type="checkbox" id="show_pwd" aria-controls="password">
            <label for="show_pwd">Afficher le mot de passe</label>

            <label for="date_naissance">Date de naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance">

            <label for="adresse">Adresse :</label>
            <textarea id="adresse" name="adresse"></textarea>

            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville">

            <label for="code_postal">Code postal :</label>
            <input type="text" id="code_postal" name="code_postal" maxlength="5">

            <label for="telephone">Téléphone :</label>
            <input type="tel" id="telephone" name="telephone">

            <label for="diplome">Diplôme :</label>
            <input type="text" id="diplome" name="diplome">

            <label for="experience_annees">Années d’expérience :</label>
            <input type="number" id="experience_annees" name="experience_annees" min="0">

            <label for="disponibilites">Disponibilités :</label>
            <textarea id="disponibilites" name="disponibilites"></textarea>

            <label for="motivation">Motivation :</label>
            <textarea id="motivation" name="motivation"></textarea>

            <label for="cv">CV  :</label>
            <input type="file" id="cv" name="cv">

            <button type="submit">S’inscrire</button>
        </form>




