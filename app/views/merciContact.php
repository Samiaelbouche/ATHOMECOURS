<?php include '../partial/header.php'; ?>
<main class="merci-page">


    <div class="success-msg" id="successMsg">
         Votre message a été envoyé avec succès. Merci de nous avoir contactés !
    </div>

    <h1>Merci </h1>
    <p>Nous vous répondrons rapidement.</p>
    <a href="home.php" class="btn">Retour à l’accueil</a>
</main>

->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const msg = document.getElementById("successMsg");
        if (msg) {
            setTimeout(() => {
                msg.style.opacity = "0";
                setTimeout(() => msg.remove(), 600);
            }, 5000);
        }
    });
</script>

<?php include '../partial/footer.php'; ?>
