<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);
?>



    <?php if ($error): ?>
        <p  class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>


            <form class="formeleve" action="../php/inscriptionEleve.php" method="POST">
                <h2>Inscription élève </h2>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance">

                <label for="adresse">Adresse :</label>
                <textarea id="adresse" name="adresse" required></textarea>

                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required>

                <label for="code_postal">Code postal :</label>
                <input type="text" id="code_postal" name="code_postal" maxlength="5" required>

                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone" required>

                <label for="niveau_scolaire">Niveau scolaire :</label>
                <select id="niveau_scolaire" name="niveau_scolaire" required>
                    <option value="collége">Collège</option>
                    <option value="lycée">Lycée</option>
                </select>

                <label for="classe">Classe :</label>
                <input type="text" id="classe" name="classe" required>

                <label for="etablissement">Établissement :</label>
                <input type="text" id="etablissement" name="etablissement">

                <h3>Informations parent</h3>

                <label for="nom_parent">Nom du parent :</label>
                <input type="text" id="nom_parent" name="nom_parent" required>

                <label for="telephone_parent">Téléphone du parent :</label>
                <input type="tel" id="telephone_parent" name="telephone_parent" required>

                <label for="email_parent">Email du parent :</label>
                <input type="email" id="email_parent" name="email_parent" required>

                <label for="besoins_particuliers">Besoins particuliers :</label>
                <textarea id="besoins_particuliers" name="besoins_particuliers" required></textarea>

                <button type="submit">Enregistrer</button>
            </form>

