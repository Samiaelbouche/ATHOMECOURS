

        <?php if (!empty($_SESSION["error"])): ?>
            <div class="msg error"><?= htmlspecialchars($_SESSION["error"]) ?></div>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <div class="admin-login">
            <div class="admin-banner">Espace Administrateur</div>

            <form method="post" action="../admin/adminLoginProcess.php">
                <input type="hidden" name="role" value="admin">

                <label>Email :</label>
                <input type="email" name="email" required>

                <label>Mot de passe :</label>
                <input type="password" name="mot_de_passe" required>

                <button type="submit">Connexion</button>
            </form>
        </div>