<?php
if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];
} else {
    die("Lien invalide");
}
?>


<div class="containerreset">
    <h2>Réinitialiser votre mot de passe</h2>
    <form action="../mdp/mdpmaj.php" method="post" class="mdpform">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required minlength="8">

        <label for="password_confirm">Confirmez le mot de passe</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8">
        <div class="show-password">
            <input type="checkbox" id="show_pwd" aria-controls="password password_confirm">
            <label for="show_pwd">Afficher les mots de passe</label>
        </div>
        <button type="submit"> Mettre à jour</button>
    </form>
</div>

