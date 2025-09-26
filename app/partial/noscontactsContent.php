<section class="contact-info">
    <h2>Contactez-nous</h2>
    <p>N’hésitez pas à nous écrire ou à nous suivre sur nos réseaux.</p>

    <div class="contact-details">
        <p><strong>Email :</strong> <a href="mailto:contact@athomecours.fr">contact@athomecours.fr</a></p>
        <p><strong>Téléphone :</strong> <a href="tel:+33612345678">+33 6 12 34 56 78</a></p>
        <p><strong>LinkedIn :</strong> <a href="https://www.linkedin.com/company/athomecours" target="_blank">At Home Cours</a></p>
        <p><strong>Instagram :</strong> <a href="https://www.instagram.com/athomecours" target="_blank">@athomecours</a></p>
    </div>
</section>

<section class="contact-form">

    <h2>Envoyer un message</h2>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1) {
            echo '<p class="error-msg">️ Merci de remplir tous les champs correctement.</p>';
        } elseif ($_GET['error'] == 2) {
            echo '<p class="error-msg"> Une erreur est survenue lors de l’envoi du message. Réessayez plus tard.</p>';
        }
    }
    ?>

    <form action="../php/contactTraitement.php" method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="objet">Objet</label>
            <input type="text" id="objet" name="objet" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn">Envoyer</button>
    </form>
</section>
