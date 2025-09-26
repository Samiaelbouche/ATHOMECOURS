<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION["error"] ?? null;
$success = $_SESSION["success"] ?? null;
unset($_SESSION["error"], $_SESSION["success"]);
?>



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
                    <option value="professeur">Professeur(e)</option>
                </select>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit">Se connecter</button>
            </form>
            <p class="forgot"><a href="../mdp/mdpoublie.php">Mot de passe oublié ?</a></p>
        </div>







